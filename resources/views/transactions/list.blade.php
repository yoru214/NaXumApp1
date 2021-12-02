<!DOCTYPE html>
<html>
<head>
    <title>laravel datatables server side example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
    <div class="container" style="margin-top: 100px;margin-bottom: 100px; ">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white"><h5>Transaction Listing</h5></div>
                    <div class="card-body">
                         <table class="data-table mdl-data-table dataTable" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Purchaser</th>
                                    <th>Distributor</th>
                                    <th>Referred Distributor</th>
                                    <th>Order Date</th>
                                    <th>Order Total</th>
                                    <th>Percentage</th>
                                    <th>Commision</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
       $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('transactions') }}",
                columns: [
                    { "data": "invoice" },
                    { "data": "purchaser" },
                    { "data": "distributor" },
                    { "data": "referred" },
                    { "data": "order_date" },
                    { "data": "order_total" },
                    { "data": "percentage" },
                    { "data": "commission" },
                ],
            });
        });
    </script>
</body>
</html>