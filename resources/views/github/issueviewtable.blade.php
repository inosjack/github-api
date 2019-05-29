@if($status == "success")
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{--- Total number of open issues--}}
            {{--- Number of open issues that were opened in the last 24 hours--}}
            {{--- Number of open issues that were opened more than 24 hours ago but less than 7 days ago--}}
            {{--- Number of open issues that were opened more than 7 days ago--}}
            <table class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th scope="col">Total number of open issues</th>
                    <th scope="col">Number of open issues that were opened in the last 24 hours</th>
                    <th scope="col">Number of open issues that were opened more than 24 hours ago but less than 7 days ago</th>
                    <th scope="col">Number of open issues that were opened more than 7 days ago</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>{{ $total_open_issue }}</th>
                    <td>{{ $nub_of_open_in_last_24h }}</td>
                    <td>{{ $nub_of_open_in_last_24h_lt_7d }}</td>
                    <td>{{ $nub_of_open_more_thn_7d }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="row justify-content-center">
        <div class="col-md-12">
            <p>$error</p>
        </div>
    </div>
@endif