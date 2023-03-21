<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Statistics
{
    static function graph($period)
    {
        $total_amount_deposits = 0;
        $total_amount_orders = 0;
        $transaction = [];
        $orders = [];
        foreach (Transaction::where('confirmations', 1)->get() as $item) {
            if (
                Carbon::parse($item->created_at) > Carbon::parse($period['start']) &&
                Carbon::parse($item->created_at) < Carbon::parse($period['end'])
            ) {
                $transaction[] = ['balance_change' => $item->balance_change, 'created_at' => $item->created_at->format('d')];
                $total_amount_deposits = $total_amount_deposits + $item->balance_change;
            }
        }
        foreach (Order::where('status', 1)->get() as $item) {
            if (
                Carbon::parse($item->created_at) > Carbon::parse($period['start']) &&
                Carbon::parse($item->created_at) < Carbon::parse($period['end'])
            ) {
                $orders[] = ['price' => $item->price, 'created_at' => $item->created_at->format('d')];
                $total_amount_orders = $total_amount_orders + $item->price;
            }
        }
        $total_count_transaction = count($transaction);
        $total_count_orders = count($orders);
        $graph_transaction = [];
        $graph_orders = [];
        for ($i = 1; $i <= Carbon::parse($period['end'])->format('d'); $i++) {
            $balance_change = 0;
            $count_deposit = 0;
            foreach ($transaction as $value) {
                if ($value['created_at'] == $i) {
                    $balance_change = $value['balance_change'] + $balance_change;
                    $count_deposit = $count_deposit + 1;
                }
            }
            $graph_transaction[] = ['created_at' => $i, 'balance_change' => $balance_change, 'count_deposit' => $count_deposit];
        }
        for ($i = 1; $i <= Carbon::parse($period['end'])->format('d'); $i++) {
            $price = 0;
            $count_order = 0;
            foreach ($orders as $value) {
                if ($value['created_at'] == $i) {
                    $price = $value['price'] + $price;
                    $count_order = $count_order + 1;
                }
            }
            $graph_orders[] = ['created_at' => $i, 'price' => $price, 'count_order' => $count_order];
        }
        return compact('graph_transaction', 'graph_orders', 'total_amount_deposits', 'total_count_transaction');
    }
    static function getProducts($column)
    {
        $values = [];
        $ids = [];
        foreach (OrderProducts::with('products')->get() as $item) {
            $values[] = $item->products->$column;
            $ids[] = $item->products->id;
        }
        $valueCounts = array_count_values($values);
        arsort($valueCounts);
        $states = [];
        foreach ($valueCounts as $state => $count) {
            $states[] = ['state' => $state, 'count' => $count];
        }
        $total = array_reduce($states, function ($carry, $item) {
            return $carry + $item['count'];
        });
        return [$states[0]];
    }
    static function getProductsStatistics($period, $column)
    {
        // $periodDate = Carbon::now()->subDay($period);
        // return $period;
        $values = [];
        $ids = [];
        foreach (OrderProducts::with('products')->get() as $item) {
            if (
                Carbon::parse($item->created_at) > Carbon::parse($period['start'])
                && Carbon::parse($item->created_at) < Carbon::parse($period['end'])
            ) {
                $values[] = $item->products->$column;
                $ids[] = $item->products->id;
            }
        }
        $valueCounts = array_count_values($values);
        arsort($valueCounts);
        $data = [];
        foreach ($valueCounts as $name => $count) {
            $data[] = ['name' => $name, 'count' => $count];
        }
        $total = array_reduce($data, function ($carry, $item) {
            return $carry + $item['count'];
        });
        $coefficients = array_map(function ($item) use ($total) {
            $ratio = $item['count'] / $total * 100;
            return [
                'name' => $item['name'],
                'count' => $item['count'],
                'ratio' => round($ratio, 2)
            ];
        }, $data);
        return compact('coefficients');
    }
    static function getProductsUserStatistics($period, $column)
    {
        $values = [];
        $ids = [];
        foreach (OrderProducts::with('products', 'order')->get() as $item) {
            if (
                Carbon::parse($item->created_at) > Carbon::parse($period['start'])
                && Carbon::parse($item->created_at) < Carbon::parse($period['end']) &&
                $item->order->user_id === auth()->id()
            ) {
                $values[] = $item->products->$column;
                $ids[] = $item->products->id;
            }
        }
        $valueCounts = array_count_values($values);
        arsort($valueCounts);
        $data = [];
        foreach ($valueCounts as $name => $count) {
            $data[] = ['name' => $name, 'count' => $count];
        }
        $total = array_reduce($data, function ($carry, $item) {
            return $carry + $item['count'];
        });
        $coefficients = array_map(function ($item) use ($total) {
            $ratio = $item['count'] / $total * 100;
            return [
                'name' => $item['name'],
                'count' => $item['count'],
                'ratio' => round($ratio, 2)
            ];
        }, $data);
        return compact('coefficients');
    }
}
