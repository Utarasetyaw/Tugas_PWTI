<?php

namespace App\Http\Controllers;

use App\PembelianBuku;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Pengaturan;

class LaporanController extends Controller
{
	private $now;

	public function __construct()
	{
		$this->now = Carbon::now();
	}

	public function index()
	{
		return view('laporan.index');
	}

	public function penjualan(Request $request)
	{
		$tahun = $request->tahun ?? $this->now->year;
		$bulan = $request->bulan ?? $this->now->month;

		$transaksi = Transaksi::whereYear('transaksi.created_at', $tahun)->whereMonth('transaksi.created_at', $bulan);

		$total = $transaksi->count();
		$pendapatan = $transaksi->sum('total_harga');
		$bukuTerjual = $transaksi->join('detail_transaksi as dt', 'dt.id_transaksi', '=', 'transaksi.id')
			->select(DB::raw('SUM(dt.jumlah) as buku_terjual'))
			->first();

		$waktuMasukan = Carbon::parse($tahun . '-' . $bulan);

		return response()->json([
			'status' => 200,
			'totalTransaksi' => $total,
			'bukuTerjual' => (int) $bukuTerjual->buku_terjual,
			'pendapatan' => (int) $pendapatan,
			'tahun' => $tahun,
			'bulan' => $waktuMasukan->monthName
		]);

		
	}

	public function pembelian(Request $request)
	{
		$tahun = $request->tahun ?? $this->now->year;
		$bulan = $request->bulan ?? $this->now->month;

		$pembelian = PembelianBuku::whereYear('pembelian_buku.tanggal', $tahun)->whereMonth('pembelian_buku.tanggal', $bulan);

		$totalPembelian = $pembelian->count();
		$pengeluaran = $pembelian->sum('total_harga');
		$bukuTerbeli = $pembelian->join('detail_pembelian_buku as dp', 'dp.id_pembelian', '=', 'pembelian_buku.id')
			->select(DB::raw('SUM(dp.jumlah) as buku_terbeli'))
			->first();

		$waktuMasukan = Carbon::parse($tahun . '-' . $bulan);

		return response()->json([
			'status' => 200,
			'totalPembelian' => $totalPembelian,
			'bukuTerbeli' => (int) $bukuTerbeli->buku_terbeli,
			'pengeluaran' => (int) $pengeluaran,
			'tahun' => $tahun,
			'bulan' => $waktuMasukan->monthName
		]);
	}

	public function pdfpenjualan($tahun, $bulan)
	{
		$tahun = $tahun ?? $this->now->year;
		$bulan = $bulan ?? $this->now->month;

		$transaksi = Transaksi::whereYear('transaksi.created_at', $tahun)->whereMonth('transaksi.created_at', $bulan);

		$totalTransaksi = $transaksi->count();
		$pendapatan = $transaksi->sum('total_harga');
		$bukuTerjual = $transaksi->join('detail_transaksi as dt', 'dt.id_transaksi', '=', 'transaksi.id')
			->select(DB::raw('SUM(dt.jumlah) as buku_terjual'))
			->first();

		$waktuMasukan = Carbon::parse($tahun . '-' . $bulan);
		$pengaturan = Pengaturan::first();

		return PDF::loadView('transaksi.laporan', compact('totalTransaksi', 'pendapatan', 'bukuTerjual', 'waktuMasukan', 'pengaturan'))->setPaper('a4', 'potrait')->download('laporan_transaksi_' . $waktuMasukan->month . '_' . $waktuMasukan->year . '.pdf');
	}

	public function pdfpembelian($tahun, $bulan) {
		$tahun = $tahun ?? $this->now->year;
		$bulan = $bulan ?? $this->now->month;

		$pembelian = PembelianBuku::whereYear('pembelian_buku.tanggal', $tahun)->whereMonth('pembelian_buku.tanggal', $bulan);

		$totalPembelian = $pembelian->count();
		$pengeluaran = $pembelian->sum('total_harga');
		$bukuTerbeli = $pembelian->join('detail_pembelian_buku as dp', 'dp.id_pembelian', '=', 'pembelian_buku.id')
			->select(DB::raw('SUM(dp.jumlah) as buku_terbeli'))
			->first();

		$waktuMasukan = Carbon::parse($tahun . '-' . $bulan);
		$pengaturan = Pengaturan::first();

		return PDF::loadView('pembelian_buku.laporan', compact('totalPembelian', 'pengeluaran', 'bukuTerbeli', 'waktuMasukan', 'pengaturan'))->setPaper('a4', 'potrait')->download('laporan_pembelian_' . $waktuMasukan->month . '_' . $waktuMasukan->year . '.pdf');
	}
}
