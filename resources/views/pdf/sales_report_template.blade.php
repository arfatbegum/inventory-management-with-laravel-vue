<!DOCTYPE html>
<html>

<head>
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            color: #333;
        }

        h2,
        h3 {
            color: #4a4a4a;
        }

        /* Summary section */
        .summary p {
            margin: 5px 0;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            font-size: 12px;
        }

        thead {
            background-color: #6c5ce7;
            color: #fff;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #e0e0e0;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        tbody tr:hover {
            background-color: #dfe6e9;
        }

        ul {
            padding-left: 20px;
            margin: 0;
        }

        ul li {
            list-style-type: disc;
            margin-bottom: 2px;
        }

        @media print {

            table,
            th,
            td {
                border: 1px solid #bbb;
            }
        }
    </style>
</head>

<body>
    <h2>Sales Report ({{ $dateFrom }} to {{ $dateTo }})</h2>

    <div class="summary">
        <h3>Summary</h3>
        <table>
            <thead>
                <tr>
                    <th>Report</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>VAT</th>
                    <th>Payable</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Sales Report</td>
                    <td>{{ $summary['totalSales'] }}</td>
                    <td>{{ $summary['totalDiscount'] }}</td>
                    <td>{{ $summary['totalVat'] }}</td>
                    <td>{{ $summary['totalPayable'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h3>Invoices</h3>
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Mobile</th>
                <th>Total</th>
                <th>Payable</th>
                <th>Products</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->customer->name }}</td>
                <td>{{ $invoice->customer->mobile }}</td>
                <td>{{ $invoice->total }}</td>
                <td>{{ $invoice->payable }}</td>
                <td>
                    <ul>
                        @foreach($invoice->invoiceProducts as $item)
                        <li>{{ $item->product->name }} x {{ $item->qty }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $invoice->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>