<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary  elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link">
        <img src="{{ asset('assets/img/logoapotik.png') }}" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light" style="color:transparent">SIM Apotik</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-header">MAIN MENU</li>
                <li class="nav-item">
                    <a href="{{ route('administrator.home.index') }}"
                        class="nav-link shadow-none {{ request()->is('administrator/home*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-solid fa-cube"></i>
                        <p>Home</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('penjualan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Penjualan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('penjualan') }}"
                                class="nav-link {{ request()->is('penjualan') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Order Penjualan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('administrator/laporan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Laporan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptpembelian') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptpembelian*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Pembelian</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptpenjualan') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptpenjualan') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Penjualan</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptrekappenjualan') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptrekappenjualan') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Rekap Penjualan</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptgembong') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptgembong') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Penjualan Gembong</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptpenjualanresep') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptpenjualanresep') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Penjualan Resep</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptlabarugi') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptlabarugi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Laba/Rugi</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptstok') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptstok') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Stok</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptpersediaan') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptpersediaan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Persediaan</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporanretur.rptreturpembelian') }}"
                                class="nav-link {{ request()->is('laporanretur.rptreturpembelian*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Retur Pembelian</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporanretur.rptreturpenjualan') }}"
                                class="nav-link {{ request()->is('laporanretur.rptreturpenjualan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Retur Penjualan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('utility*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-reguler fa-user"></i>

                        <p>
                            Utiity
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('utility.gantipassword') }}"
                                class="nav-link {{ request()->is('utility.gantipassword') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Update Password</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-header">LOGOUT</li>
                <li class="nav-item">
                    <a class="nav-link shadow-none" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off nav-icon"></i>
                        <p>{{ __('Logout') }}</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
