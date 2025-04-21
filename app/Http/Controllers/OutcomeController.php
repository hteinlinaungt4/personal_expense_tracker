<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Outcome;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OutcomeController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('outcome.index',compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

       try {
        $outcome = new Outcome();
        $outcome->user_id = Auth::user()->id;
        $outcome->category_id = $request->category_id;
        $outcome->amount = $request->amount;
        $outcome->description = $request->description;
        $outcome->save();

        return response()->json(['message' => 'outcome created successfully']);
       } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
       }

    }


    public function outcomeDatatable(Request $request){
        $outcomes = Outcome::with('category')->where('user_id', Auth::user()->id);
        return datatables()->of($outcomes)
        ->addColumn('category_name', function ($outcome) {
            return optional($outcome->category)->name ?? '';
        })
        ->filterColumn('category_name', function ($query, $keyword) {
            $query->whereHas('category', function ($q1) use ($keyword) {
                $q1->where('name', 'like', '%' . $keyword . '%');
            });
        })
        ->editColumn('amount', function ($outcome) {
            return number_format($outcome->amount, 2,) . ' ' . 'MMK';
        })
        ->addColumn('date', function ($outcome) {
            return $outcome->created_at->format('Y-m-d');
        })
        ->addColumn('actions', function ($outcome) {
            return view('outcome.action', compact('outcome'));
        })
        ->make(true);
    }

    public function show($id){
        $outcome = Outcome::find($id);

        if (!$outcome) {
            return response()->json(['message' => 'outcome not found'], 404);
        }

        return response()->json($outcome);
    }

    public function update(Request $request, $id){
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        try {
            $outcome = Outcome::findOrFail($id);
            $outcome->category_id = $request->category_id;
            $outcome->amount = $request->amount;
            $outcome->description = $request->description;
            $outcome->save();

            return response()->json(['message' => 'outcome updated successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function destroy($id){
        $outcome = Outcome::findOrFail($id);
        $outcome->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }


    public function outcomeChart(){
        $last7Daysoutcome = Outcome::selectRaw('DATE(created_at) as date, SUM(amount) as total')
        ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
        ->where('user_id', Auth::id())
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->pluck('total', 'date');




        $last6Weeksoutcome = Outcome::selectRaw("YEAR(created_at) as year, WEEK(created_at, 1) as week, SUM(amount) as total")
            ->where('created_at', '>=', Carbon::now()->subWeeks(5)->startOfWeek()) // 6 weeks including current week
            ->where('user_id', Auth::user()->id)
            ->groupBy('year', 'week')
            ->orderBy('year')
            ->orderBy('week')
            ->get()
            ->mapWithKeys(function ($item) {
                return ["{$item->year}-W{$item->week}" => $item->total];
            });


        $last6Monthsoutcome = Outcome::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(amount) as total")
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth()) // 6 months including current month
            ->where('user_id', Auth::user()->id)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');


        $totaloutcomeAmount = Outcome::where('user_id', Auth::user()->id)->sum('amount');


        return view('outcome.chart', compact('last7Daysoutcome', 'last6Weeksoutcome', 'last6Monthsoutcome', 'totaloutcomeAmount'));

    }
}
