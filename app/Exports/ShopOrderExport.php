<?php

namespace App\Exports;

use App\Models\ShopOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShopOrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ShopOrder::with('customer')->get()->map(function ($order) {
            return [
                'ID' => $order->id,
                'Customer Name' => $order->customer->name,
                'Phone' => $order->customer->phone,
                'Email' => $order->customer->email,
                'Total Price' => $order->total_price,
                'Order Status' => $order->order_status,
                'Payment Status' => $order->payment_status,
                'Date Order' => $order->date_order->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer Name',
            'Phone',
            'Email',
            'Total Price',
            'Order Status',
            'Payment Status',
            'Date Order',
        ];
    }
}
