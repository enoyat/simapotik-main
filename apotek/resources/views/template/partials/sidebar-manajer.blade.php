<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary  elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link">
        <img src="{{ asset('assets/img/logoapotik.png') }}" class="brand-image">
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
                    <a href="#" class="nav-link {{ request()->is('order*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-regular fa-money-bill"></i>
                        <p>
                            Pembelian
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('order') }}"
                                class="nav-link {{ request()->is('order') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Order Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('order.trorder') }}"
                                class="nav-link {{ request()->is('order/trorder*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kiriman Masuk</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('pembelian.retur') }}"
                                class="nav-link {{ request()->is('pembelian/retur') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Pembelian</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('supplier.index') }}"
                                class="nav-link shadow-none {{ request()->is('supplier*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Supplier</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->is('administrator/administrasiakademik*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-taxi"></i>
                        <p>
                            Mutasi Stok
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('mutasi.index') }}"
                                class="nav-link {{ request()->is('mutasi*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Mutasi Stok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mutasi.rptmutasi') }}"
                                class="nav-link {{ request()->is('rptmutasi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cetak Mutasi Stok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stoklokasi.index') }}"
                                class="nav-link {{ request()->is('stoklokasi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lokasi Stok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kartustok.index') }}"
                                class="nav-link {{ request()->is('kartustok') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu Stok</p>
                            </a>
                        </li>


                    </ul>

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
                            <a href="{{ route('penjualan.retur') }}"
                                class="nav-link {{ request()->is('penjualan/retur') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer.index') }}"
                                class="nav-link shadow-none {{ request()->is('customer*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sesionuser') }}"
                                class="nav-link shadow-none {{ request()->is('sesionuser*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Session Kasir</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('barang*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-reguler fa-file-archive"></i>

                        <p>
                            Produk
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('jenis.index') }}"
                                class="nav-link {{ request()->is('jenis*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jenis Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('golongan.index') }}"
                                class="nav-link {{ request()->is('golongan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Golongan Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barang.index') }}"
                                class="nav-link {{ request()->is('obat*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kategori.index') }}"
                                class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Etalase</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dokter.index') }}"
                        class="nav-link shadow-none {{ request()->is('dokter*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-solid fa-cube"></i>
                        <p>Dokter</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('stokopname*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-reguler fa-file-archive"></i>

                        <p>
                            Stok Opname
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('stokopname.index') }}"
                                class="nav-link {{ request()->is('stokopname') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cetak Stok</p>
                            </a>
                        </li>
                        @if (Auth::user()->roles_id == '10')
                            <li class="nav-item">
                                <a href="{{ route('stokopname.stok') }}"
                                    class="nav-link {{ request()->is('stokopname/stok*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Adjustment Stok</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('stokopname.rptstokopname') }}"
                                class="nav-link {{ request()->is('stokopname/rpt*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cetak Stok Opname</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stokopname.expstokopname') }}"
                                class="nav-link {{ request()->is('stokopname/exp*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Export Excel Stok Opname</p>
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
                            <a href="{{ route('utility.userpassword') }}"
                                class="nav-link {{ request()->is('utility.userpassword') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('utility.register') }}"
                                class="nav-link {{ request()->is('utility.register') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Register Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('utility.gantipassword') }}"
                                class="nav-link {{ request()->is('utility.gantipassword') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Update Password</p>
                            </a>
                        </li>

                    </ul>
                </li>
                {{-- History --}}
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('hs*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-regular fa-money-bill"></i>
                        <p>
                            History Transaksi
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('hspembelian.retur') }}"
                                class="nav-link {{ request()->is('hspembelian/retur') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Pembelian</p>
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="{{ route('mutasi.rptmutasi') }}"
                                class="nav-link {{ request()->is('rptmutasi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cetak Mutasi Stok</p>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{ route('hskartustok.index') }}"
                                class="nav-link {{ request()->is('hskartustok') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu Stok</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('hspenjualan.retur') }}"
                                class="nav-link {{ request()->is('hspenjualan/retur') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Penjualan</p>
                            </a>
                        </li>
                        {{--
                        <li class="nav-item">
                            <a href="{{ route('stokopname.index') }}"
                                class="nav-link {{ request()->is('stokopname') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cetak Stok</p>
                            </a>
                        </li> --}}

                        {{--
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptpembelian') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptpembelian*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptpenjualan') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptpenjualan') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptrekappenjualan') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptrekappenjualan') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Rekap Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptsehati') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptsehati') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Penjualan Sehati</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptgembong') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptgembong') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Penjualan Gembong</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptpenjualanresep') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptpenjualanresep') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Penjualan Resep</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptlabarugi') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptlabarugi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Laba/Rugi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporantransaksi.rptstok') }}"
                                class="nav-link {{ request()->is('laporantransaksi.rptstok') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Stok</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('hslaporantransaksi.rptpersediaan') }}"
                                class="nav-link {{ request()->is('hslaporantransaksi.rptpersediaan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Persediaan</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('laporanretur.rptreturpembelian') }}"
                                class="nav-link {{ request()->is('laporanretur.rptreturpembelian*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Retur Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporanretur.rptreturpenjualan') }}"
                                class="nav-link {{ request()->is('laporanretur.rptreturpenjualan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Retur Penjualan</p>
                            </a>
                        </li> --}}
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
