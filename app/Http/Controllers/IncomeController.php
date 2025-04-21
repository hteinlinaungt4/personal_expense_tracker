<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Income;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('income.index',compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

       try {
        $income = new Income();
        $income->user_id = Auth::user()->id;
        $income->category_id = $request->category_id;
        $income->amount = $request->amount;
        $income->description = $request->description;
        $income->save();

        return response()->json(['message' => 'Income created successfully']);
       } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
       }

    }


    public function incomeDatatable(Request $request){
        $incomes = Income::with('category')->where('user_id', Auth::user()->id);
        return datatables()->of($incomes)
        ->addColumn('category_name', function ($income) {
            return optional($income->category)->name ?? '';
        })
        ->filterColumn('category_name', function ($query, $keyword) {
            $query->whereHas('category', function ($q1) use ($keyword) {
                $q1->where('name', 'like', '%' . $keyword . '%');
            });
        })
        ->editColumn('amount', function ($income) {
            return number_format($income->amount, 2,) . ' ' . 'MMK';
        })
        ->addColumn('date', function ($income) {
            return $income->created_at->format('Y-m-d');
        })
        ->addColumn('actions', function ($income) {
            return view('income.action', compact('income'));
        })
        ->make(true);
    }

    public function show($id){
        $income = Income::find($id);

        if (!$income) {
            return response()->json(['message' => 'Income not found'], 404);
        }

        return response()->json($income);
    }

    public function update(Request $request, $id){
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        try {
            $income = Income::findOrFail($id);
            $income->category_id = $request->category_id;
            $income->amount = $request->amount;
            $income->description = $request->description;
            $income->save();

            return response()->json(['message' => 'Income updated successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function destroy($id){
        $income = Income::findOrFail($id);
        $income->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }


    public function incomeChart(){
        $last7DaysIncome = Income::selectRaw('DATE(created_at) as date, SUM(amount) as total')
        ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
        ->where('user_id', Auth::id())
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->pluck('total', 'date');




        $last6WeeksIncome = Income::selectRaw("YEAR(created_at) as year, WEEK(created_at, 1) as week, SUM(amount) as total")
            ->where('created_at', '>=', Carbon::now()->subWeeks(5)->startOfWeek()) // 6 weeks including current week
            ->where('user_id', Auth::id())
            ->groupBy('year', 'week')
            ->orderBy('year')
            ->orderBy('week')
            ->get()
            ->mapWithKeys(function ($item) {
                return ["{$item->year}-W{$item->week}" => $item->total];
            });


        $last6MonthsIncome = Income::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(amount) as total")
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth()) // 6 months including current month
            ->where('user_id', Auth::id())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');


        $totalIncomeAmount = Income::where('user_id', Auth::user()->id)->sum('amount');


        return view('income.chart', compact('last7DaysIncome', 'last6WeeksIncome', 'last6MonthsIncome', 'totalIncomeAmount'));

    }
}
