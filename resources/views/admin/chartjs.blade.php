<canvas id="myChart" width="400" height="400"></canvas>
<script>
    $(function () {
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @for($i = 0; $i < count($rows); $i++)
                        @if ($i == count($rows) - 1)
                            "{{ $rows[$i][1] }}"
                        @else
                            "{{ $rows[$i][1] }}",
                        @endif
                    @endfor
                ],
                datasets: [{
                    label: '# of Number',
                    data: [
                        @for($i = 0; $i < count($rows); $i++)
                            @if ($i == count($rows) - 1)
                                {{ $rows[$i][2] }}
                            @else
                                {{ $rows[$i][2] }},
                            @endif
                        @endfor
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    });
</script>