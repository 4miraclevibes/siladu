        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo m-0 border-bottom">
              <a href="{{ route('home') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                  <img src="https://siladu.unp.ac.id/assets/logo.png" style="max-width: 200px" alt="">
                </span>
              </a>
              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
              </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1 mt-3">
              <!-- Dashboard -->
              <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-home"></i>
                  <div data-i18n="Dashboard">Dashboard</div>
                </a>
              </li>

              <!-- Users -->
              <li class="menu-item {{ Route::is('users*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-user"></i>
                  <div data-i18n="Users">Admin</div>
                </a>
              </li>
              <!-- Laboratories -->
              <li class="menu-item {{ Route::is('laboratories*') ? 'active' : '' }}">
                <a href="{{ route('laboratories.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-test-tube"></i>
                  <div data-i18n="Laboratories">Laboratories</div>
                </a>
              </li>
              <!-- Packages -->
              <li class="menu-item {{ Route::is('packages*') ? 'active' : '' }}">
                <a href="{{ route('packages.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-package"></i>
                  <div data-i18n="Packages">Packages</div>
                </a>
              </li>
              <!-- Parameters -->
              <li class="menu-item {{ Route::is('parameters*') ? 'active' : '' }}">
                <a href="{{ route('parameters.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-up-arrow"></i>
                  <div data-i18n="Parameters">Parameters</div>
                </a>
              </li>
              <!-- Methods -->
              <li class="menu-item {{ Route::is('methods*') ? 'active' : '' }}">
                <a href="{{ route('methods.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-cog"></i>
                  <div data-i18n="Methods">Methods</div>
                </a>
              </li>
              <!-- Locations -->
              <li class="menu-item {{ Route::is('locations*') ? 'active' : '' }}">
                <a href="{{ route('locations.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-location-plus"></i>
                  <div data-i18n="Locations">Locations</div>
                </a>
              </li>
              <!-- Quality Standarts -->
              <li class="menu-item {{ Route::is('quality-standarts*') ? 'active' : '' }}">
                <a href="{{ route('quality-standarts.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-check-shield"></i>
                  <div data-i18n="Quality Standarts">Quality Standarts</div>
                </a>
              </li>
              <!-- Transactions -->
              <li class="menu-item {{ Route::is('dashboard.transactions.index') ? 'active' : '' }}">
                <a href="{{ route('dashboard.transactions.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-file"></i>
                  <div data-i18n="Transactions">Transactions</div>
                </a>
              </li>
              <!-- Payments -->
              <li class="menu-item {{ Route::is('dashboard.payments.index') ? 'active' : '' }}">
                <a href="{{ route('dashboard.payments.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-money"></i>
                  <div data-i18n="Payments">Payments</div>
                </a>
              </li>
            </ul>
          </aside>
          <!-- / Menu -->
