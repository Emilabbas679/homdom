<main class="main">

    <div class="section_wrap wrap_my_profile_balance">

        <div class="my_anc_menu">
            {{template file='homdom.block.profile_header'}}
        </div>

        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <div class="report_select">
                        <form action="" method="GET">
                            <div class="custom_select report_type_slc">
                                <select name="select" id="" class="select-regist">
                                    <option value="">Bütün elanlar</option>
                                    <option value="">Mənzil</option>
                                    <option value="">Kirayə evlər</option>
                                    <option value="">Bağ evi</option>
                                </select>
                            </div>
                            <div class="custom_select report_date_slc">
                                <select name="select" id="" class="select-regist">
                                    <option value="" disabled>Tarix aralığı seç</option>
                                    <option value="">Dünən</option>
                                    <option value="">Son 7 gün</option>
                                    <option value="">Son 30 gün</option>
                                    <option value="">Tarixi özün seç</option>
                                </select>
                            </div>
                            <div class="report_date_input">
                                <input type="text" data-toggle="datepicker" name="start_date" value="01.08.2021" placeholder="">
                                <input type="text" data-toggle="datepicker" name="end_date" value="19.08.2021" placeholder="">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="prf_balance_container">

                    <!-- <div id="resizable" style="height: 330px;">
                      <div id="chartContainer1" style="height: 100%; width: 100%;"></div>
                    </div> -->
                    <div class="chart-container" style="position: relative;  width:100%">
                        <canvas id="myChart"></canvas>
                    </div>

                </div>

            </div>
        </div>
    </div>


</main>


@section('js')

<script src="/theme/frontend/homdom/style/js/chart.js"></script>

<script>
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        margin: 0,
        padding: 0,
        responsive: true,
        aspectRatio: 2,
        maintainAspectRatio: true,
        data: {
            layout: {
                margin: {
                    left: 0,
                    right: 0,
                },
                padding: {
                    left: 0,
                    right: 0,
                }
            },
            labels: ['', '', '', '', '', '','', '', '', '', '', '','', '', '', '', '', '','', ''],
            datasets: [{
                label: '',
                data: [1, 60, 56, 30, 20, 2, 3, 40, 19, 38, 50, 2, 12, 19, 3, 5, 2, 12, 19, 3],
                backgroundColor: [
                    '#1E315C'
                ],
                borderColor: [
                    '#ffffff'
                ],
                borderWidth: 1,
                barPercentage: 1

            }]
        },
        options: {
            scales: {
                x: {
                    display: false,
                    grid: {
                        display: false,
                    },

                    ticks: {
                        backdropPadding: {
                            x: 100,
                            y: 400
                        }
                    }
                },
                y: {
                    display: false,
                    beginAtZero: true,
                    grid: {
                        display: false,
                    },
                    ticks: {
                        backdropPadding: {
                            x: 100,
                            y: 400
                        }
                    }
                },
            },
            layout: {
                margin: 0,
                padding: 0,
            },
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        color: '#00ff00'
                    }
                },
                title: {
                    display: false,
                    text: 'Custom Chart Title'
                },
            }
        }
    });
</script>

@endsection