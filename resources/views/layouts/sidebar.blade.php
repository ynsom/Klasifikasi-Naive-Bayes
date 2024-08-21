 <!-- Menu -->

 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
     <div class="app-brand demo">
         <a href="/" class="app-brand-link">
             <span class="app-brand-logo demo">
                 <span class="app-brand-text demo menu-text fw-bolder ms-2">Klasifikasi Ojek</span>
         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
             <i class="bx bx-chevron-left bx-sm align-middle"></i>
         </a>
     </div>

     <div class="menu-inner-shadow"></div>

     <ul class="menu-inner py-1">
         <!-- Dashboard -->
         <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
             <a href="/dashboard" class="menu-link">
                 <i class="menu-icon tf-icons fa-solid fa-house"></i>
                 <div data-i18n="Analytics">Dashboard</div>
             </a>
         </li>

         <li class="menu-header small text-uppercase">
             <span class="menu-header-text">Pages</span>
         </li>

         <li class="menu-item {{ request()->is('dashboard/review') ? 'active' : '' }}">
             <a href="{{ route('review.index') }}" class="menu-link ">
                 <i class="menu-icon tf-icons  fa-solid fa-stars"></i>
                 <div data-i18n="Analytics">Review</div>
             </a>
         </li>
         <li class="menu-item {{ request()->is('dashboard/dataset') ? 'active' : '' }}">
             <a href="{{ route('dataset.index') }}" class="menu-link ">
                 <i class="menu-icon tf-icons fa-solid fa-database"></i>
                 <div data-i18n="Analytics">Dataset</div>
             </a>
         </li>
         <li class="menu-item {{ request()->is('dashboard/users') ? 'active' : '' }}">
             <a href="{{ route('users.index') }}" class="menu-link">
                 <i class="menu-icon tf-icons fa-solid fa-users"></i>
                 <div data-i18n="Analytics">User</div>
             </a>
         </li>

     </ul>
 </aside>
 <!-- / Menu -->
