<?php
use App\Http\Controllers\Administrator\HomeController as AdministratorHomeController;
use App\Http\Controllers\Akun;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Kelompokakun;
use App\Http\Controllers\Laporan;
use App\Http\Controllers\LaporanTransaksi;
use App\Http\Controllers\LaporanGembong;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MStransaksi;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\Operator\HomeController as OperatorHomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Pembelian;
use App\Http\Controllers\Penjualan;
use App\Http\Controllers\Postingjurnal;
use App\Http\Controllers\Postingjurnalpenyesuaian;
use App\Http\Controllers\SesionuserController;
use App\Http\Controllers\StokAwalController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\Subtransaksi;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Trjurnalpenyesuaian;
use App\Http\Controllers\Trkeuangan;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\Penjualanresep;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PolyController;
use App\Http\Controllers\JenispasienController;
use App\Http\Controllers\LaporanRetur;
use App\Http\Controllers\StokController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', function () {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
Route::get('/access', [App\Http\Controllers\HomeController::class, 'access'])->name('access');
// Roles Administrator

Route::group(['middleware' => ['web', 'auth', 'roles']], function () {
    Route::group(['roles' => ['administrator', 'operator', 'adminunit']], function () {
        Route::get('administrator/home', [AdministratorHomeController::class, 'index'])->name('administrator.home.index');
        Route::get('utility/gantipassword', [UtilityController::class, 'gantipassword'])->name('utility.gantipassword');
        Route::post('utility/userpasswordupdate', [UtilityController::class, 'userpasswordupdate'])->name('utility.userpasswordupdate');

        Route::group(['prefix' => 'pembelian'], function () {
            Route::get('/', [Pembelian::class, 'index'])->name('pembelian');
            Route::get('baru', [Pembelian::class, 'baru'])->name('pembelian.baru');
            Route::post('cart', [Pembelian::class, 'cart'])->name('pembelian.cart');
            Route::post('carthapus', [Pembelian::class, 'carthapus'])->name('pembelian.carthapus');
            Route::get('cartview', [Pembelian::class, 'cartview'])->name('pembelian.cartview');
            Route::post('store', [Pembelian::class, 'store'])->name('pembelian.store');
            Route::get('invoice', [Pembelian::class, 'invoice'])->name('pembelian.invoice');
            Route::get('trpembelian', [Pembelian::class, 'trpembelian'])->name('pembelian.trpembelian');
            Route::get('trdetail/{id}', [Pembelian::class, 'trdetail'])->name('pembelian.trdetail');
            Route::delete('hapuspembelian/{id}', [Pembelian::class, 'hapuspembelian'])->name('pembelian.hapuspembelian');
            Route::get('caribarang', [Pembelian::class, 'caribarang'])->name('pembelian.caribarang');
            Route::get('fetch', [Pembelian::class, 'fetch'])->name('pembelian.fetch');
            Route::get('retur', [Pembelian::class, 'retur'])->name('pembelian.retur');
            Route::get('fetchretur', [Pembelian::class, 'fetchretur'])->name('pembelian.fetchretur');
            Route::get('inbond/{id}', [Pembelian::class, 'inbond'])->name('pembelian.inbond');
            Route::post('approveretur', [Pembelian::class, 'approveretur'])->name('pembelian.approveretur');
            Route::get('formretur', [Pembelian::class, 'formretur'])->name('pembelian.formretur');
            Route::get('invoiceretur', [Pembelian::class, 'invoiceretur'])->name('pembelian.invoiceretur');
            Route::get('listretur/{id}', [Pembelian::class, 'listretur'])->name('pembelian.listretur');
            Route::get('trreturdetail/{id}', [Pembelian::class, 'trreturdetail'])->name('pembelian.trreturdetail');
            Route::delete('hapusreturpembelian/{id}', [Pembelian::class, 'hapusreturpembelian'])->name('pembelian.hapusreturpembelian');
            Route::get('inretur/{id}', [Pembelian::class, 'inretur'])->name('pembelian.inretur');
            Route::get('forminretur', [Pembelian::class, 'forminretur'])->name('pembelian.forminretur');
            Route::post('approveinretur', [Pembelian::class, 'approveinretur'])->name('pembelian.approveinretur');

        });
        Route::group(['prefix' => 'penjualan'], function () {
            Route::get('/', [Penjualan::class, 'index'])->name('penjualan');
            Route::get('baru', [Penjualan::class, 'baru'])->name('penjualan.baru');
            Route::post('cart', [Penjualan::class, 'cart'])->name('penjualan.cart');
            Route::post('carthapus', [Penjualan::class, 'carthapus'])->name('penjualan.carthapus');
            Route::get('cartview', [Penjualan::class, 'cartview'])->name('penjualan.cartview');
            Route::post('store', [Penjualan::class, 'store'])->name('penjualan.store');
            Route::get('invoice', [Penjualan::class, 'invoice'])->name('penjualan.invoice');
            Route::get('trpenjualan', [Penjualan::class, 'trpenjualan'])->name('penjualan.trpenjualan');
            Route::get('trdetail/{id}', [Penjualan::class, 'trdetail'])->name('penjualan.trdetail');
            Route::delete('hapuspenjualan/{id}', [Penjualan::class, 'hapuspenjualan'])->name('penjualan.hapuspenjualan');
            Route::get('caribarang', [Penjualan::class, 'caribarang'])->name('penjualan.caribarang');
            Route::get('fetch', [Penjualan::class, 'fetch'])->name('penjualan.fetch');

            Route::get('retur', [Penjualan::class, 'retur'])->name('penjualan.retur');
            Route::get('fetchretur', [Penjualan::class, 'fetchretur'])->name('penjualan.fetchretur');
            Route::get('inbond/{id}', [Penjualan::class, 'inbond'])->name('penjualan.inbond');
            Route::post('approveretur', [Penjualan::class, 'approveretur'])->name('penjualan.approveretur');
            Route::get('formretur', [Penjualan::class, 'formretur'])->name('penjualan.formretur');
            Route::get('invoiceretur', [Penjualan::class, 'invoiceretur'])->name('penjualan.invoiceretur');
            Route::get('listretur/{id}', [Penjualan::class, 'listretur'])->name('penjualan.listretur');
            Route::get('trreturdetail/{id}', [Penjualan::class, 'trreturdetail'])->name('penjualan.trreturdetail');
            Route::delete('hapusreturpenjualan/{id}', [Penjualan::class, 'hapusreturpenjualan'])->name('penjualan.hapusreturpenjualan');
            Route::get('trdetailresep/{id}', [Penjualan::class, 'trdetailresep'])->name('penjualan.trdetailresep');
            Route::post('ubahtipepenjualan', [Penjualan::class, 'ubahtipepenjualan'])->name('penjualan.ubahtipepenjualan');
        });
        Route::group(['prefix' => 'penjualanresep'], function () {
            Route::get('/', [Penjualanresep::class, 'index'])->name('penjualanresep');
            Route::get('baru', [Penjualanresep::class, 'baru'])->name('penjualanresep.baru');
            Route::post('cart', [Penjualanresep::class, 'cart'])->name('penjualanresep.cart');
            Route::post('carthapus', [Penjualanresep::class, 'carthapus'])->name('penjualanresep.carthapus');
            Route::get('cartview', [Penjualanresep::class, 'cartview'])->name('penjualanresep.cartview');
            Route::post('store', [Penjualanresep::class, 'store'])->name('penjualanresep.store');
            Route::get('invoice', [Penjualanresep::class, 'invoice'])->name('penjualanresep.invoice');
            Route::get('trpenjualan', [Penjualanresep::class, 'trpenjualan'])->name('penjualanresep.trpenjualan');
            Route::get('trdetail/{id}', [Penjualanresep::class, 'trdetail'])->name('penjualanresep.trdetail');
            Route::delete('hapuspenjualan/{id}', [Penjualanresep::class, 'hapuspenjualan'])->name('penjualanresep.hapuspenjualan');
            Route::get('caribarang', [Penjualanresep::class, 'caribarang'])->name('penjualanresep.caribarang');
            Route::get('fetch', [Penjualanresep::class, 'fetch'])->name('penjualanresep.fetch');
        });
    });
    Route::group(['roles' => ['administrator']], function () {

        Route::group(['prefix' => 'laporantransaksi'], function () {
            Route::get('rptpembelian', [LaporanTransaksi::class, 'rptpembelian'])->name('laporantransaksi.rptpembelian');
            Route::post('laporanpembelian', [LaporanTransaksi::class, 'laporanpembelian'])->name('laporantransaksi.laporanpembelian');
            Route::get('rptpenjualan', [LaporanTransaksi::class, 'rptpenjualan'])->name('laporantransaksi.rptpenjualan');
            Route::post('laporanpenjualan', [LaporanTransaksi::class, 'laporanpenjualan'])->name('laporantransaksi.laporanpenjualan');
            Route::get('rptlabarugi', [LaporanTransaksi::class, 'rptlabarugi'])->name('laporantransaksi.rptlabarugi');
            Route::post('laporanlabarugi', [LaporanTransaksi::class, 'laporanlabarugi'])->name('laporantransaksi.laporanlabarugi');
            Route::get('rptstok', [LaporanTransaksi::class, 'rptstok'])->name('laporantransaksi.rptstok');
            Route::post('laporanstok', [LaporanTransaksi::class, 'laporanstok'])->name('laporantransaksi.laporanstok');
            Route::get('fetch', [LaporanTransaksi::class, 'fetch'])->name('laporantransaksi.fetch');
            Route::get('rptpenjualanresep', [LaporanTransaksi::class, 'rptpenjualanresep'])->name('laporantransaksi.rptpenjualanresep');
            Route::post('laporanpenjualanresep', [LaporanTransaksi::class, 'laporanpenjualanresep'])->name('laporantransaksi.laporanpenjualanresep');
            Route::get('rptpersediaan', [LaporanTransaksi::class, 'rptpersediaan'])->name('laporantransaksi.rptpersediaan');
            Route::post('laporanpersediaan', [LaporanTransaksi::class, 'laporanpersediaan'])->name('laporantransaksi.laporanpersediaan');
            Route::get('rptgembong', [LaporanGembong::class, 'rptpenjualan'])->name('laporantransaksi.rptgembong');
            Route::post('laporanpenjualangembong', [LaporanGembong::class, 'laporanpenjualan'])->name('laporantransaksi.laporanpenjualangembong');

            Route::get('rptrekappenjualan', [LaporanTransaksi::class, 'rptrekappenjualan'])->name('laporantransaksi.rptrekappenjualan');
            Route::post('laporanrekappenjualan', [LaporanTransaksi::class, 'laporanrekappenjualan'])->name('laporantransaksi.laporanrekappenjualan');



        });
        Route::group(['prefix' => 'laporanretur'], function () {
            Route::get('rptreturpembelian', [LaporanRetur::class, 'rptreturpembelian'])->name('laporanretur.rptreturpembelian');
            Route::post('laporanreturpembelian', [LaporanRetur::class, 'laporanreturpembelian'])->name('laporanretur.laporanreturpembelian');
            Route::get('rptreturpenjualan', [LaporanRetur::class, 'rptreturpenjualan'])->name('laporanretur.rptreturpenjualan');
            Route::post('laporanreturpenjualan', [LaporanRetur::class, 'laporanreturpenjualan'])->name('laporanretur.laporanreturpenjualan');

        });

        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index'])->name('barang.index');
            Route::get('create', [BarangController::class, 'create'])->name('barang.create');
            Route::post('store', [BarangController::class, 'store'])->name('barang.store');
            Route::post('destroy', [BarangController::class, 'destroy'])->name('barang.destroy');
            Route::get('edit/{kdorder}', [BarangController::class, 'edit'])->name('barang.edit');
            Route::post('update', [BarangController::class, 'update'])->name('barang.update');
            Route::post('uploadgallery', [BarangController::class, 'uploadgallery'])->name('barang.uploadgallery');
            Route::get('hapusgallery/{kdorder}', [BarangController::class, 'hapusgallery'])->name('barang.hapusgallery');
            Route::get('getjenis', [BarangController::class, 'getjenis'])->name('barang.getjenis');
            Route::get('getgolongan', [BarangController::class, 'getgolongan'])->name('barang.getgolongan');
            Route::get('getbarang', [BarangController::class, 'getbarang'])->name('barang.getbarang');

            Route::get('fetch', [BarangController::class, 'fetch'])->name('barang.fetch');

        });
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', [SupplierController::class, 'index'])->name('supplier.index');
            Route::get('create', [SupplierController::class, 'create'])->name('supplier.create');
            Route::post('store', [SupplierController::class, 'store'])->name('supplier.store');
            Route::post('destroy', [SupplierController::class, 'destroy'])->name('supplier.destroy');
            Route::get('edit/{kdorder}', [SupplierController::class, 'edit'])->name('supplier.edit');
            Route::post('update', [SupplierController::class, 'update'])->name('supplier.update');
            Route::get('getsupplier', [SupplierController::class, 'getsupplier'])->name('supplier.getsupplier');

        });
        Route::group(['prefix' => 'stoklokasi'], function () {
            Route::get('/', [LokasiController::class, 'index'])->name('stoklokasi.index');
            Route::get('create', [LokasiController::class, 'create'])->name('stoklokasi.create');
            Route::post('store', [LokasiController::class, 'store'])->name('stoklokasi.store');
            Route::post('destroy', [LokasiController::class, 'destroy'])->name('stoklokasi.destroy');
            Route::get('edit/{kdorder}', [LokasiController::class, 'edit'])->name('stoklokasi.edit');
            Route::post('update', [LokasiController::class, 'update'])->name('stoklokasi.update');
        });
        Route::group(['prefix' => 'customer'], function () {
            Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
            Route::get('create', [CustomerController::class, 'create'])->name('customer.create');
            Route::post('store', [CustomerController::class, 'store'])->name('customer.store');
            Route::post('destroy', [CustomerController::class, 'destroy'])->name('customer.destroy');
            Route::get('edit/{kdorder}', [CustomerController::class, 'edit'])->name('customer.edit');
            Route::post('update', [CustomerController::class, 'update'])->name('customer.update');
            Route::get('getcustomer', [CustomerController::class, 'getcustomer'])->name('customer.getcustomer');

        });
        Route::group(['prefix' => 'dokter'], function () {
            Route::get('/', [DokterController::class, 'index'])->name('dokter.index');
            Route::get('create', [DokterController::class, 'create'])->name('dokter.create');
            Route::post('store', [DokterController::class, 'store'])->name('dokter.store');
            Route::post('destroy', [DokterController::class, 'destroy'])->name('dokter.destroy');
            Route::get('edit/{kdorder}', [DokterController::class, 'edit'])->name('dokter.edit');
            Route::post('update', [DokterController::class, 'update'])->name('dokter.update');
            Route::get('getdokter', [DokterController::class, 'getdokter'])->name('dokter.getdokter');

        });
        Route::group(['prefix' => 'poly'], function () {
            Route::get('/', [PolyController::class, 'index'])->name('poly.index');
            Route::get('create', [PolyController::class, 'create'])->name('poly.create');
            Route::post('store', [PolyController::class, 'store'])->name('poly.store');
            Route::post('destroy', [PolyController::class, 'destroy'])->name('poly.destroy');
            Route::get('edit/{kdorder}', [PolyController::class, 'edit'])->name('poly.edit');
            Route::post('update', [PolyController::class, 'update'])->name('poly.update');
            Route::get('getpoly', [PolyController::class, 'getpoly'])->name('poly.getpoly');

        });
        Route::group(['prefix' => 'jenispasien'], function () {
            Route::get('/', [JenispasienController::class, 'index'])->name('jenispasien.index');
            Route::get('create', [JenispasienController::class, 'create'])->name('jenispasien.create');
            Route::post('store', [JenispasienController::class, 'store'])->name('jenispasien.store');
            Route::post('destroy', [JenispasienController::class, 'destroy'])->name('jenispasien.destroy');
            Route::get('edit/{kdorder}', [JenispasienController::class, 'edit'])->name('jenispasien.edit');
            Route::post('update', [JenispasienController::class, 'update'])->name('jenispasien.update');
            Route::get('getjenispasien', [JenispasienController::class, 'getjenispasien'])->name('jenispasien.getjenispasien');

        });
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
            Route::get('create', [KategoriController::class, 'create'])->name('kategori.create');
            Route::post('store', [KategoriController::class, 'store'])->name('kategori.store');
            Route::post('destroy', [KategoriController::class, 'destroy'])->name('kategori.destroy');
            Route::get('edit/{kdorder}', [KategoriController::class, 'edit'])->name('kategori.edit');
            Route::post('update', [KategoriController::class, 'update'])->name('kategori.update');
        });

        Route::group(['prefix' => 'jenis'], function () {
            Route::get('/', [JenisController::class, 'index'])->name('jenis.index');
            Route::get('create', [JenisController::class, 'create'])->name('jenis.create');
            Route::post('store', [JenisController::class, 'store'])->name('jenis.store');
            Route::post('destroy', [JenisController::class, 'destroy'])->name('jenis.destroy');
            Route::get('edit/{kdorder}', [JenisController::class, 'edit'])->name('jenis.edit');
            Route::post('update', [JenisController::class, 'update'])->name('jenis.update');
        });

        Route::group(['prefix' => 'golongan'], function () {
            Route::get('/', [GolonganController::class, 'index'])->name('golongan.index');
            Route::get('create', [GolonganController::class, 'create'])->name('golongan.create');
            Route::post('store', [GolonganController::class, 'store'])->name('golongan.store');
            Route::post('destroy', [GolonganController::class, 'destroy'])->name('golongan.destroy');
            Route::get('edit/{kdorder}', [GolonganController::class, 'edit'])->name('golongan.edit');
            Route::post('update', [GolonganController::class, 'update'])->name('golongan.update');
        });
        Route::group(['prefix' => 'stokopname'], function () {
            Route::get('/', [StokOpnameController::class, 'index'])->name('stokopname.index');
            Route::post('cetakstok', [StokOpnameController::class, 'cetakstok'])->name('stokopname.cetakstok');
            Route::get('fetch', [StokOpnameController::class, 'fetch'])->name('stokopname.fetch');
            Route::get('adjustment', [StokOpnameController::class, 'adjustment'])->name('stokopname.adjustment');
            Route::get('stok', [StokOpnameController::class, 'stok'])->name('stokopname.stok');
            Route::get('create/{id}', [StokOpnameController::class, 'create'])->name('stokopname.create');
            Route::post('store', [StokOpnameController::class, 'store'])->name('stokopname.store');
            Route::get('rptstokopname', [StokOpnameController::class, 'rptstokopname'])->name('stokopname.rptstokopname');
            Route::post('cetakstokopname', [StokOpnameController::class, 'cetakstokopname'])->name('stokopname.cetakstokopname');
        });
        Route::group(['prefix' => 'stokawal'], function () {
            Route::get('/', [StokAwalController::class, 'index'])->name('stokawal.index');
            Route::get('baru', [StokAwalController::class, 'baru'])->name('stokawal.baru');
            Route::post('cart', [StokAwalController::class, 'cart'])->name('stokawal.cart');
            Route::post('carthapus', [StokAwalController::class, 'carthapus'])->name('stokawal.carthapus');
            Route::get('cartview', [StokAwalController::class, 'cartview'])->name('stokawal.cartview');
            Route::post('store', [StokAwalController::class, 'store'])->name('stokawal.store');
            Route::get('invoice', [StokAwalController::class, 'invoice'])->name('stokawal.invoice');
            Route::get('trpembelian', [StokAwalController::class, 'trpembelian'])->name('stokawal.trpembelian');
            Route::get('trdetail/{id}', [StokAwalController::class, 'trdetail'])->name('stokawal.trdetail');
            Route::delete('hapuspembelian/{id}', [StokAwalController::class, 'hapuspembelian'])->name('stokawal.hapuspembelian');
        });
        Route::group(['prefix' => 'order'], function () {
            Route::get('/', [OrderController::class, 'index'])->name('order');
            Route::get('baru', [OrderController::class, 'baru'])->name('order.baru');
            Route::post('cart', [OrderController::class, 'cart'])->name('order.cart');
            Route::post('carthapus', [OrderController::class, 'carthapus'])->name('order.carthapus');
            Route::get('cartview', [OrderController::class, 'cartview'])->name('order.cartview');
            Route::post('store', [OrderController::class, 'store'])->name('order.store');
            Route::get('invoice', [OrderController::class, 'invoice'])->name('order.invoice');
            Route::get('trorder', [OrderController::class, 'trorder'])->name('order.trorder');
            Route::get('trdetail/{id}', [OrderController::class, 'trdetail'])->name('order.trdetail');
            Route::delete('hapusorder/{id}', [OrderController::class, 'hapusorder'])->name('order.hapusorder');
            Route::get('inbond/{id}', [OrderController::class, 'inbond'])->name('order.inbond');
            Route::post('approve', [OrderController::class, 'approve'])->name('order.approve');
            Route::get('invoicepembelian', [OrderController::class, 'invoicepembelian'])->name('order.invoicepembelian');
            Route::get('rincianorder', [OrderController::class, 'rincianorder'])->name('order.rincianorder');
            Route::get('caribarang', [OrderController::class, 'caribarang'])->name('order.caribarang');
            Route::get('fetch', [OrderController::class, 'fetch'])->name('order.fetch');

        });
        Route::group(['prefix' => 'mutasi'], function () {
            Route::get('/', [MutasiController::class, 'index'])->name('mutasi.index');
            Route::get('baru', [MutasiController::class, 'baru'])->name('mutasi.baru');
            Route::post('cart', [MutasiController::class, 'cart'])->name('mutasi.cart');
            Route::post('carthapus', [MutasiController::class, 'carthapus'])->name('mutasi.carthapus');
            Route::get('cartview', [MutasiController::class, 'cartview'])->name('mutasi.cartview');
            Route::post('store', [MutasiController::class, 'store'])->name('mutasi.store');
            Route::get('invoice', [MutasiController::class, 'invoice'])->name('mutasi.invoice');
            Route::get('trpembelian', [MutasiController::class, 'trpembelian'])->name('mutasi.trpembelian');
            Route::get('listproduk', [MutasiController::class, 'listproduk'])->name('mutasi.listproduk');

            Route::get('trdetail/{id}', [MutasiController::class, 'trdetail'])->name('mutasi.trdetail');
            Route::delete('hapusmutasi/{id}', [MutasiController::class, 'hapusmutasi'])->name('mutasi.hapusmutasi');
            Route::get('rptmutasi', [MutasiController::class, 'rptmutasi'])->name('mutasi.rptmutasi');
            Route::post('laporanmutasi', [MutasiController::class, 'laporanmutasi'])->name('mutasi.laporanmutasi');


        });

        Route::group(['prefix' => 'sesionuser'], function () {
            Route::get('/', [SesionuserController::class, 'index'])->name('sesionuser');
            Route::post('store', [SesionuserController::class, 'store'])->name('sesionuser.store');

            Route::get('create', [SesionuserController::class, 'create'])->name('sesionuser.create');
            Route::get('edit/{id}', [SesionuserController::class, 'edit'])->name('sesionuser.edit');
            Route::post('update/{id}', [SesionuserController::class, 'update'])->name('sesionuser.update');
            Route::get('getuser', [SesionuserController::class, 'getuser'])->name('sesionuser.getuser');
            Route::get('show/{id}', [SesionuserController::class, 'show'])->name('sesionuser.show');

        });
        Route::group(['prefix' => 'kartustok'], function () {
            Route::get('/', [StokController::class, 'index'])->name('kartustok.index');
            Route::get('laporankartustok', [StokController::class, 'laporankartustok'])->name('kartustok.laporankartustok');
        });
        Route::get('utility/userpassword', [UtilityController::class, 'userpassword'])->name('utility.userpassword');
        Route::get('utility/register', [UtilityController::class, 'register'])->name('utility.register');
        Route::post('utility/postregister', [UtilityController::class, 'postregister'])->name('utility.postregister');
        Route::delete('utility/userdelete/{id}', [UtilityController::class, 'userdelete'])->name('userdelete');

    });
});
