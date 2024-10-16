<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PaymentInvoiceMail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;



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

    public function sendInvoiceByEmail($id){
        $payment = Payment::with('order.customer')->findOrFail($id);
        $customerEmail = $payment->order->customer->email;

        // Tạo PDF hóa đơn
        $pdf = PDF::loadView('payments.pdf', compact('payment'))->output();

        // gửi email kèm pdf
        Mail::to($customerEmail)->send(new PaymentInvoiceMail($payment, $pdf));

        return back()->with('success', 'Hóa đơn đã được gửi qua email cho khách hàng.');

    }

}
