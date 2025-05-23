 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
         <div class="sidebar-brand-icon rotate-n-15">
             <i class="fas fa-laugh-wink"></i>
         </div>
         <div class="sidebar-brand-text mx-3">PE Tracker</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item @yield('dashboard') ">
         <a class="nav-link" href="index.html">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Interface
     </div>

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item @yield('income')">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
             aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-hand-holding-usd"></i>
             <span>Income</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub Income Lists</h6>
                <a class="collapse-item" href="{{route('income.index')}}">Lists</a>
                <a class="collapse-item" href="{{route('income.chart')}}">Chart</a>
             </div>
         </div>
     </li>

     <!-- Nav Item - Utilities Collapse Menu -->
     <li class="nav-item @yield('outcome')">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
             aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fas fa-fw  fa-coins"></i>
             <span>Outcome</span>
         </a>
         <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sub Outcome Lists</h6>
                <a class="collapse-item" href="{{route('outcome.index')}}">Lists</a>
                <a class="collapse-item" href="{{route('outcome.chart')}}">Chart</a>
             </div>
         </div>
     </li>

     <!-- Nav Item - Categroy Collapse Menu -->
     <li class="nav-item @yield('category')">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categories"
             aria-expanded="true" aria-controls="categories">
             <i class="fas fa-fw fa-list"></i>
             <span>Categories</span>
         </a>
         <div id="categories" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Sub Categories:</h6>
                 <a class="collapse-item" href="{{route('category.index')}}">Lists</a>
             </div>
         </div>
     </li>


     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>


 </ul>
 <!-- End of Sidebar -->
