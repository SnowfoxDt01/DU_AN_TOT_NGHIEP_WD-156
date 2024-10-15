<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;



class PaymentController extends Controller
{
    // Phương thức hiển thị danh sách hóa đơn
    public function index()
    {
        
        $payments = Payment::with(['order.customer'])->get(); // Lấy tất cả hóa đơn cùng với thông tin đơn hàng liên quan
        // dd($payments);
        return view('payments.index', compact('payments')); // Trả về view danh sách hóa đơn
    }

    // Phương thức hiển thị chi tiết hóa đơn
    public function show($id)
    {
        $payment = Payment::with('order')->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    // Phương thức xuất hóa đơn ra PDF
    public function exportPDF($id){
        $payment = Payment::with('order.customer')->findOrFail($id); // Tải đơn hàng cùng với khách hàng liên quan
        

        // Tạo view cho hóa đơn
        $pdf = PDF::loadView('payments.pdf', compact('payment'));

        // Xuất PDF
        return $pdf->download('payment_invoice_' . $payment->id . '.pdf');
    }


}
