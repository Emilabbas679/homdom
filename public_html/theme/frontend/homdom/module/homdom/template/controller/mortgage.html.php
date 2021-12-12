<main class="main">


    <div class="section_wrap wrap_main">

        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <h1 class="address_h">{{ phrase var='homdom.mortgage_calculator'}} </h1>
                </div>
                <div class="section_wrap wrap_mortgage" id="_calculator">
                    <div class="morgage_left">
                        <div class="range_sect">
                            <div class="mortg_title">
                                <div class="report_date_input">
                                    <input type="text" id="_birthDate" data-toggle="datepicker" name="customer_date" value="" placeholder="Doğum tarixi">
                                </div>
                            </div>
                        </div>
                        <div class="range_sect">
                            <div class="mortg_title">
                                <span class="mr_title_name">{{phrase var='homdom.family_member_count' }}</span>
                            </div>
                            <div class="row_rg_input">
                                <input type="number" min="1" max="15" step="1"class="range_val decimal" value="1" maxlength="5" id="_familyComposition"/>
                                <span class="rg_icons">👥</span>
                            </div>
                            <input type="range" min="1" max="15" step="1" class="range_slider decimal" value="1" />
                        </div>
                        <div class="range_sect">
                            <div class="mortg_title">
                                <div class="custom_select2">
                                    <!-- <select name="select" class="select-regist" id="_type">
                                      <option value="0" selected>Adi </option>
                                      <option value="1">Güzəştli </option>
                                    </select> -->
                                    <select class="js-example-basic-single " name="select" id="_type">
                                        <option value="false" selected>{{phrase var='homdom.normal'}} </option>
                                        <option value="true">{{phrase var='homdom.discounted'}} </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="range_sect">
                            <div class="mortg_title">
                                <div class="custom_select">
                                    <select name="select" class="select-regist">
                                        <option value="" disabled>{{phrase var='homdom.choose'}} </option>
                                        <option value="">{{phrase var='homdom.apartments_over_1970'}}  </option>
                                        <option value="">{{phrase var='homdom.apartments_over_2013'}}</option>
                                        <option value="">{{ phrase var='homdom.private_houses' }}</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <div class="range_sect">
                            <div class="mortg_title">
                                <span class="mr_title_name">{{phrase var='homdom.monthly_salary'}}</span>
                            </div>
                            <div class="row_rg_input">
                                <input type="number" min="150" max="20000" step="1" class="range_val decimal" value="150" maxlength="5" id="_monthlyIncome"/>
                                <span class="rg_icons">₼</span>
                            </div>
                            <input type="range" min="150" max="20000" step="1" class="range_slider decimal" value="150" />
                        </div>
                        <div class="range_sect">
                            <div class="mortg_title">
                                <span class="mr_title_name">{{phrase var='homdom.property_value'}}</span>
                                <span class="btn_tooltip">?</span>
                                <span class="mrt_tooltip">{{phrase var='homdom.property_value_description'}}</span>
                            </div>
                            <div class="row_rg_input">
                                <input type="number" min="15000" max="600000" step="1000"class="range_val property_val decimal" value="15000" maxlength="6" id="_houseValue"/>
                                <span class="rg_icons">₼</span>
                            </div>
                            <input type="range" min="15000" max="600000" step="1000" class="range_slider decimal" value="15000" />
                        </div>
                        <div class="range_sect">
                            <div class="mortg_title">
                                <span class="mr_title_name">{{phrase var='homdom.interest_rate'}}</span>
                            </div>
                            <div class="row_rg_input">
                                <input type="number" min="4" max="8" step="0.1" class="range_val decimal" value="4" maxlength="5" id="_paymentPercentage"/>
                                <span class="rg_icons">%</span>
                            </div>
                            <input type="range" min="4" max="8" step="0.1" class="range_slider decimal" value="4" />
                        </div>
                        <div class="range_sect">
                            <div class="mortg_title">
                                <span class="mr_title_name">{{phrase var='homdom.initial_payment'}}</span>
                                <span class="mr_title_pecent">20 % </span>
                            </div>
                            <div class="row_rg_input">
                                <input type="number" min="6000" max="60000" step="1000"class="range_val decimal" value="6000" maxlength="6" id="_initialPayment"/>
                                <span class="rg_icons">₼</span>
                            </div>
                            <input type="range" min="6000" max="60000" step="1000" class="range_slider decimal" value="6000" />
                        </div>
                        <div class="range_sect">
                            <div class="mortg_title">
                                <span class="mr_title_name">{{phrase var='homdom.period'}}</span>
                            </div>
                            <div class="row_rg_input">
                                <input type="number" min="36" max="360" step="1"class="range_val decimal" value="36" maxlength="6" id="_creditPeriod"/>
                                <span class="rg_icons">ay</span>
                            </div>
                            <input type="range" min="36" max="360" step="1" class="range_slider decimal" value="36" />
                        </div>
                        <div class="range_sect">
                            <div class="mortg_title">
                                <span class="mr_title_name">{{phrase var='homdom.other_liabilities'}}</span>
                                <span class="mr_title_pecent">20 % </span>
                            </div>
                            <div class="row_rg_input">
                                <input type="number" min="20" max="150" step="10"class="range_val decimal" value="30" maxlength="6" id="_otherLiab"/>
                                <span class="rg_icons">₼</span>
                            </div>
                            <input type="range" min="20" max="150" step="10" class="range_slider decimal" value="30" />
                        </div>
                    </div>
                    <div class="morgage_right">
                        <div class="mortage_result" id="_result">

                            <div class="range_sect">
                                <div class="mortg_title">
                                    <span class="mr_title_name">{{phrase var='homdom.monthly_payment'}} </span>
                                </div>
                                <div class="row_rg_input">
                                    <span class="mrt_result_val " id="_monthlyPayment">0</span>
                                    <span class="mresult_type">₼</span>
                                </div>
                            </div>
                            <div class="range_sect">
                                <div class="mortg_title">
                                    <span class="mr_title_name">{{phrase var='homdom.amount_of_credit'}} </span>
                                </div>
                                <div class="row_rg_input">
                                    <span class="mrt_result_val" id="_creditAmount">0 </span>
                                    <span class="mresult_type">₼</span>
                                </div>
                            </div>
                            <div class="range_sect">
                                <div class="mortg_title">
                                    <span class="mr_title_name">{{phrase var='homdom.monthly_insurance'}} </span>
                                </div>
                                <div class="row_rg_input">
                                    <span class="mrt_result_val" id="_insurancePayment">0 </span>
                                    <span class="mresult_type">₼</span>
                                </div>
                            </div>
                            <button class="mrt_reset_btn" id="mrt_reset_btn">{{ phrase var='homdom.reset_all' }} </button>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


</main>
@section('js')
<script src="/theme/frontend/homdom/style/js/datepicker.min.js"></script>
<script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script>
//Date
        $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        format: 'dd.mm.yyyy',
        minDate: '-1m'
        });

    </script>
@endsection