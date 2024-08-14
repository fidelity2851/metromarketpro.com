<div>
    <div class="table-responsive ">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th class="table_head" scope="col">#</th>
                    <th class="table_head" scope="col">Trx ID</th>
                    <th class="table_head" scope="col">Client Name</th>
                    <th class="table_head" scope="col">Payment Method</th>
                    <th class="table_head" scope="col">Amount</th>
                    <th class="table_head" scope="col">Status</th>
                    <th class="table_head" scope="col">Created On</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deposits as $item)
                <tr>
                    <th class="table_data" scope="row"> {{ $loop->iteration }} </th>
                    <th class="table_data" scope="row"> {{ $item->trx_num }} </th>
                    <td class="table_data">{{ $item->user->fullname }}</td>
                    <td class="table_data">{{ $item->deposit_method->name }}</td>
                    <td class="table_data">${{ number_format($item->amount) }}</td>
                    <td class="table_data">
                        @switch($item->status)
                        @case(true)
                        <span class="table_status">Success</span>
                        @break
                        @case(false)
                        <span class="table_status2">Pending</span>
                        @break
                        @default
                        <span class="table_status3">Canceled</span>
                        @endswitch
                    </td>
                    <td class="table_data">{{
                        Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($deposits->isEmpty())
    <div class="d-flex justify-content-center bg-white mb-4">
        <img src="images/no_result.png" alt="" class="">
    </div>
    @endif

    <div class="col d-flex flex-column flex-md-row justify-content-md-between align-items-end mt-3">


        {{ $deposits->links() }}
    </div>
</div>