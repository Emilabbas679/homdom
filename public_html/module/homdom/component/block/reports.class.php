<?php
/**
 * [PHPFOX_HEADER].
 */
defined('AIN') or exit('NO DICE!');

class apanel_component_block_reports extends AIN_Component
{
    public function process()
    {

        $price = AIN::getService('video.func.price');
        $table = AIN::getService('video.func.table');
        $date = AIN::getService('video.func.date');

        $aForms = array();
        $aForms['reports_title'] = AIN::getPhrase('adnetwork.statics');

        $iPage = $this->request()->getInt('page');
        $iPageSize = 60;

        if ($iPage < 1) {
            $iPage = 1;
        }

        $where['page'] = $iPage;
        $where['limit'] = $iPageSize;
		if( getUserBy('user_id') !== 1 ) $where['ssp_id'] = 1;

        $where['stats_type'] = 'get_revenue_daily';
        //$where['stats_type'] = 'get_revenue_site';
        //$where['stats_type'] = 'get_revenue_url';
        //$where['stats_type'] = 'get_revenue_format_type';

        $where['start_date'] = date('d.m.Y', AIN_TIME - 60 * 60 * 24 * 7);
        $where['end_date'] = date('d.m.Y');

        if (getGroupParam('adnetwork.can_manage_advertiser_all')) {


        } else {

            $where['user_id'] = getUserBy('user_id');
        }

        ////$where['user_id'] = getUserBy('user_id');



        if ($aVals = $this->request()->getArray('val')) {
            foreach ($aVals as $key => $value) {
                $where[$key] = $value;
            }
        }



        
        $accounting_stats = AIN::getService('video')->click_impression_stats($where);



        if ('failed' == $accounting_stats['status']) {
            AIN_ERROR::set(implode('<br/>', $accounting_stats['messages']));
        }


        switch ($where['stats_type']) {
            case 'get_revenue_daily':
            case 'get_revenue_site':
                //  case 'get_revenue_url':
            case 'get_revenue_slot':
                $total = array();
                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    $aForms['total']['impression'] += $aRow['impression'];
                    $aForms['total']['unique_impression'] += $aRow['unique_impression'];
                    $aForms['total']['reach'] += $aRow['reach'];
                    $aForms['total']['click'] += $aRow['click'];
                    $aForms['total']['unique_click'] += $aRow['unique_click'];

                    $aForms['total']['site_impression'] += $aRow['site_impression'];
                    $aForms['total']['site_click'] += $aRow['site_click'];

                    $aForms['total']['publisher_amount'] += $aRow['publisher_amount'];

                    $display = [];

                    if ($where['stats_type'] == 'get_revenue_daily') {
                        $dateArray = $date->getArray($aRow['day']);
                        $display[AIN::getPhrase('adnetwork.day')] = "{$dateArray['day']}.{$dateArray['month']}.{$dateArray['year']}";
                        $total[AIN::getPhrase('adnetwork.day')] = '-';
                    }

                    if ($where['stats_type'] == 'get_revenue_site') {
                        $display[AIN::getPhrase('adnetwork.domain')] = $aRow['domain'];
                        $total[AIN::getPhrase('adnetwork.domain')] = '-';
                    }
                    if ($where['stats_type'] == 'get_revenue_url') {
                        $display[AIN::getPhrase('adnetwork.url')] = $aRow['url'];
                        $total[AIN::getPhrase('adnetwork.url')] = '-';
                    }
                    if ($where['stats_type'] == 'get_revenue_slot') {
                        $display[AIN::getPhrase('adnetwork.id')] = "{$aRow['name']} ({$aRow['slot_id']})";
                        $total[AIN::getPhrase('adnetwork.id')] = '-';
                    }

                    $display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['site_impression']);
                    $total[AIN::getPhrase('adnetwork.impression')] += $aRow['site_impression'];

                    $display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['site_click']);
                    $total[AIN::getPhrase('adnetwork.click')] += $aRow['site_click'];

                    $display[AIN::getPhrase('adnetwork.ecpm')] = round(($aRow['publisher_amount'] / $aRow['site_impression'] * 1000), 2);
                    $total[AIN::getPhrase('adnetwork.ecpm')] = '-';

                    if ($aRow['site_click'] > 0) {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = round(($aRow['publisher_amount'] / $aRow['site_click']), 2);
                    } else {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = 0;
                    }
                    $total[AIN::getPhrase('adnetwork.ecpc')] = '-';

                    $display[AIN::getPhrase('adnetwork.ctr')] = number_format(($aRow['site_click'] / $aRow['site_impression']) * 100, 2) . '%';
                    $total[AIN::getPhrase('adnetwork.ctr')] = '-';

                    $display[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($aRow['publisher_amount']);
                    $total[AIN::getPhrase('adnetwork.publisher_amount')] += $aRow['publisher_amount'];

                    $table->add($display);
                }
                $total[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($total[AIN::getPhrase('adnetwork.publisher_amount')]);

                $table->add($total);
                $table->tfoot();
                $aForms['total']['ctr'] = number_format(($aForms['total']['site_click'] / $aForms['total']['site_impression']) * 100, 2);
                $aForms['total']['publisher_amount'] = $price->convert($aForms['total']['publisher_amount']);
                break;

            case 'get_revenue_format_type':
                $total = array();
                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    if ($aRow['impression'] == null) {
                        continue;
                    }
                    $display = [];

					$aRow['name'] = (AIN::getLib('locale')->isPhrase("adnetwork.ad_static_name_{$aRow['id']}") ? AIN::getPhrase("adnetwork.ad_static_name_{$aRow['id']}") : $aRow['name']);
                    $display[AIN::getPhrase('adnetwork.name')] = $aRow['name'];
                    $total[AIN::getPhrase('adnetwork.name')] = '-';

                    $display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['site_impression']);
                    $total[AIN::getPhrase('adnetwork.impression')] += $aRow['site_impression'];

                    $display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['site_click']);
                    $total[AIN::getPhrase('adnetwork.click')] += $aRow['site_click'];

                    $display[AIN::getPhrase('adnetwork.ecpm')] = round(($aRow['publisher_amount'] / $aRow['site_impression'] * 1000), 2);
                    $total[AIN::getPhrase('adnetwork.ecpm')] = '-';

                    if ($aRow['site_click'] > 0) {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = round(($aRow['publisher_amount'] / $aRow['site_click']), 2);
                    } else {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = 0;
                    }
                    $total[AIN::getPhrase('adnetwork.ecpc')] = '-';

                    $display[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($aRow['publisher_amount']);
                    $total[AIN::getPhrase('adnetwork.publisher_amount')] += $price->convert($aRow['publisher_amount']);

                    $table->add($display);
                }
                $table->add($total);
                $table->tfoot();
                break;

            case 'get_spent_site':
                $total = array();
                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    $display = [];

                    $display[AIN::getPhrase('adnetwork.domain')] = $aRow['domain'];
                    $total[AIN::getPhrase('adnetwork.domain')] = '-';

                    $display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['impression']);
                    $total[AIN::getPhrase('adnetwork.impression')] += $aRow['impression'];

                    $display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['click']);
                    $total[AIN::getPhrase('adnetwork.click')] += ($aRow['click']);

                    $display[AIN::getPhrase('adnetwork.unique_impression')] = number_format($aRow['unique_impression']);
                    $total[AIN::getPhrase('adnetwork.unique_impression')] += ($aRow['unique_impression']);

                    $display[AIN::getPhrase('adnetwork.reach')] = number_format($aRow['reach']);
                    $total[AIN::getPhrase('adnetwork.reach')] = '-';


                    $display[AIN::getPhrase('adnetwork.unique_click')] = number_format($aRow['unique_click']);
                    $total[AIN::getPhrase('adnetwork.unique_click')] += ($aRow['unique_click']);

					$display[AIN::getPhrase('adnetwork.video_start')] = isset($aRow['video_start']) ? number_format($aRow['video_start']) : 0;
					$total[AIN::getPhrase('adnetwork.video_start')] += ($aRow['video_start']);


					$display[AIN::getPhrase('adnetwork.firstquartile')] = isset($aRow['firstQuartile']) ? number_format($aRow['firstQuartile']) : 0;
					$total[AIN::getPhrase('adnetwork.firstquartile')] += ($aRow['firstQuartile']);

					$display[AIN::getPhrase('adnetwork.midpoint')] = isset($aRow['midpoint']) ? number_format($aRow['midpoint']) : 0;
					$total[AIN::getPhrase('adnetwork.midpoint')] += ($aRow['midpoint']);

					$display[AIN::getPhrase('adnetwork.thirdquartile')] = isset($aRow['thirdQuartile']) ? number_format($aRow['thirdQuartile']) : 0;
					$total[AIN::getPhrase('adnetwork.thirdquartile')] += ($aRow['thirdQuartile']);

					$display[AIN::getPhrase('adnetwork.complete')] = isset($aRow['complete']) ? number_format($aRow['complete']) : 0;
					$total[AIN::getPhrase('adnetwork.complete')] += ($aRow['complete']);

                    $display[AIN::getPhrase('adnetwork.spent_amount')] = $price->convert($aRow['spent_amount']);
                    $total[AIN::getPhrase('adnetwork.spent_amount')] += ($aRow['spent_amount']);

                    //$display[AIN::getPhrase('adnetwork.wallet_spent_amount')]	= $price->convert($aRow['wallet_spent_amount']);
                    ///$total[AIN::getPhrase('adnetwork.wallet_spent_amount')]		+= ($aRow['wallet_spent_amount']);

                    ////$display[AIN::getPhrase('adnetwork.publisher_amount')]	= $price->convert($aRow['publisher_amount']);
                    ////$total[AIN::getPhrase('adnetwork.publisher_amount')]	+= ($aRow['publisher_amount']);

                    ///$display[AIN::getPhrase('adnetwork.system_amount')]		= $price->convert($aRow['system_amount']);
                    ///$total[AIN::getPhrase('adnetwork.system_amount')]		+= ($aRow['system_amount']);

                    ///$display[AIN::getPhrase('adnetwork.ref_user_amount')]	= $price->convert($aRow['ref_user_amount']);
                    //$total[AIN::getPhrase('adnetwork.ref_user_amount')]		+= ($aRow['ref_user_amount']);

					$display[AIN::getPhrase('adnetwork.ecpm')] = round(($aRow['spent_amount'] / $aRow['impression'] * 1000), 2);
                    $total[AIN::getPhrase('adnetwork.ecpm')] = '-';

                    $table->add($display);
                }
                $table->add($total);
                $table->tfoot();
                break;

            case 'get_revenue_url':
                $total = array();
                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    $display = [];

                    $display[AIN::getPhrase('adnetwork.domain')] = $aRow['domain'];
                    $total[AIN::getPhrase('adnetwork.domain')] = '-';

                    $display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['impression']);
                    $total[AIN::getPhrase('adnetwork.impression')] += $aRow['impression'];

                    $display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['click']);
                    $total[AIN::getPhrase('adnetwork.click')] += ($aRow['click']);

                    $display[AIN::getPhrase('adnetwork.unique_impression')] = number_format($aRow['unique_impression']);
                    $total[AIN::getPhrase('adnetwork.unique_impression')] += ($aRow['unique_impression']);

                    $display[AIN::getPhrase('adnetwork.reach')] = number_format($aRow['reach']);
                    $total[AIN::getPhrase('adnetwork.reach')] = '-';


                    $display[AIN::getPhrase('adnetwork.unique_click')] = number_format($aRow['unique_click']);
                    $total[AIN::getPhrase('adnetwork.unique_click')] += ($aRow['unique_click']);

                    if ($aRow['video_start'] > 0) {
                        $display[AIN::getPhrase('adnetwork.video_start')] = number_format($aRow['video_start']);
                        $total[AIN::getPhrase('adnetwork.video_start')] += ($aRow['video_start']);
                    }
                    if ($aRow['firstQuartile'] > 0) {
                        $display[AIN::getPhrase('adnetwork.firstquartile')] = number_format($aRow['firstQuartile']);
                        $total[AIN::getPhrase('adnetwork.firstquartile')] += ($aRow['firstQuartile']);
                    }
                    if ($aRow['midpoint'] > 0) {
                        $display[AIN::getPhrase('adnetwork.midpoint')] = number_format($aRow['midpoint']);
                        $total[AIN::getPhrase('adnetwork.midpoint')] += ($aRow['midpoint']);
                    }
                    if ($aRow['thirdQuartile'] > 0) {
                        $display[AIN::getPhrase('adnetwork.thirdquartile')] = number_format($aRow['thirdQuartile']);
                        $total[AIN::getPhrase('adnetwork.thirdquartile')] += ($aRow['thirdQuartile']);
                    }
                    if ($aRow['complete'] > 0) {
                        $display[AIN::getPhrase('adnetwork.complete')] = number_format($aRow['complete']);
                        $total[AIN::getPhrase('adnetwork.complete')] += ($aRow['complete']);
                    }

                    $display[AIN::getPhrase('adnetwork.spent_amount')] = $price->convert($aRow['spent_amount']);
                    $total[AIN::getPhrase('adnetwork.spent_amount')] += ($aRow['spent_amount']);

                    //$display[AIN::getPhrase('adnetwork.wallet_spent_amount')]	= $price->convert($aRow['wallet_spent_amount']);
                    ///$total[AIN::getPhrase('adnetwork.wallet_spent_amount')]		+= ($aRow['wallet_spent_amount']);

                    ////$display[AIN::getPhrase('adnetwork.publisher_amount')]	= $price->convert($aRow['publisher_amount']);
                    ////$total[AIN::getPhrase('adnetwork.publisher_amount')]	+= ($aRow['publisher_amount']);

                    ///$display[AIN::getPhrase('adnetwork.system_amount')]		= $price->convert($aRow['system_amount']);
                    ///$total[AIN::getPhrase('adnetwork.system_amount')]		+= ($aRow['system_amount']);

                    ///$display[AIN::getPhrase('adnetwork.ref_user_amount')]	= $price->convert($aRow['ref_user_amount']);
                    //$total[AIN::getPhrase('adnetwork.ref_user_amount')]		+= ($aRow['ref_user_amount']);

                    $table->add($display);
                }
                $table->add($total);
                $table->tfoot();
                break;

            case 'get_spent_ad':

                //print_r($where);
                $total = array();
                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    $display = [];
                    $display[AIN::getPhrase('adnetwork.id')] = $aRow['ad_id'];
                    $total[AIN::getPhrase('adnetwork.id')] = '-';

                    $display[AIN::getPhrase('adnetwork.name')] = $aRow['name'];
                    $total[AIN::getPhrase('adnetwork.name')] = '-';

                    $display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['impression']);
                    $total[AIN::getPhrase('adnetwork.impression')] += $aRow['impression'];

                    $display[AIN::getPhrase('adnetwork.unique_impression')] = number_format($aRow['unique_impression']);
                    $total[AIN::getPhrase('adnetwork.unique_impression')] += $aRow['unique_impression'];

                    $display[AIN::getPhrase('adnetwork.reach')] = number_format($aRow['reach']);
                    $total[AIN::getPhrase('adnetwork.reach')] = '-';

                    $display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['click']);
                    $total[AIN::getPhrase('adnetwork.click')] += ($aRow['click']);

                    $display[AIN::getPhrase('adnetwork.unique_click')] = number_format($aRow['unique_click']);
                    $total[AIN::getPhrase('adnetwork.unique_click')] += ($aRow['unique_click']);


                    if (getUserBy('user_group_id') == 1) {
                        $display[AIN::getPhrase('adnetwork.site_impression')] = number_format($aRow['site_impression']);
                        $total[AIN::getPhrase('adnetwork.site_impression')] += ($aRow['site_impression']);

                        $display[AIN::getPhrase('adnetwork.site_click')] = number_format($aRow['site_click']);
                        $total[AIN::getPhrase('adnetwork.site_click')] += ($aRow['site_click']);
                    }


                    $display[AIN::getPhrase('adnetwork.ctr')] = number_format(($aRow['click'] / $aRow['impression']) * 100, 2) . '%';
                    $total[AIN::getPhrase('adnetwork.ctr')] = '-';

                    if ($aRow['site_click'] > 0) {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = round(($aRow['spent_amount'] / $aRow['site_click']), 2);
                    } else {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = 0;
                    }
                    $total[AIN::getPhrase('adnetwork.ecpc')] = '-';

					$display[AIN::getPhrase('adnetwork.video_start')] = ( isset($aRow['video_start']) ? number_format($aRow['video_start']) : 0 );
                    $total[AIN::getPhrase('adnetwork.video_start')] += $display[AIN::getPhrase('adnetwork.video_start')];

					$display[AIN::getPhrase('adnetwork.firstquartile')] = ( isset($aRow['firstQuartile']) ? number_format($aRow['firstQuartile']) : 0 );
                    $total[AIN::getPhrase('adnetwork.firstquartile')] += $display[AIN::getPhrase('adnetwork.firstquartile')];

					$display[AIN::getPhrase('adnetwork.midpoint')] = ( isset($aRow['midpoint']) ? number_format($aRow['midpoint']) : 0 );
                    $total[AIN::getPhrase('adnetwork.midpoint')] += $display[AIN::getPhrase('adnetwork.midpoint')];

					$display[AIN::getPhrase('adnetwork.thirdquartile')] = ( isset($aRow['thirdQuartile']) ? number_format($aRow['thirdQuartile']) : 0 );
                    $total[AIN::getPhrase('adnetwork.thirdquartile')] += $display[AIN::getPhrase('adnetwork.thirdquartile')];

					$display[AIN::getPhrase('adnetwork.complete')] = ( isset($aRow['complete']) ? number_format($aRow['complete']) : 0 );
                    $total[AIN::getPhrase('adnetwork.complete')] += $display[AIN::getPhrase('adnetwork.complete')];

                    $display[AIN::getPhrase('adnetwork.spent_amount')] = $price->convert($aRow['spent_amount']);
                    $total[AIN::getPhrase('adnetwork.spent_amount')] += ($aRow['spent_amount']);

                    //$display[AIN::getPhrase('adnetwork.wallet_spent_amount')]	= $price->convert($aRow['wallet_spent_amount']);
                    //$display[AIN::getPhrase('adnetwork.publisher_amount')]	= $price->convert($aRow['publisher_amount']);
                    //$display[AIN::getPhrase('adnetwork.system_amount')]	= $price->convert($aRow['system_amount']);

                    if (getUserBy('user_id') == 1) {

						$display[AIN::getPhrase('adnetwork.wallet_spent_amount')] = $price->convert($aRow['wallet_spent_amount']);
                        $total[AIN::getPhrase('adnetwork.wallet_spent_amount')] += ($aRow['wallet_spent_amount']);


						$display[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($aRow['publisher_amount']);
                        $total[AIN::getPhrase('adnetwork.publisher_amount')] += ($aRow['publisher_amount']);

                        $display[AIN::getPhrase('adnetwork.ref_user_amount')] = $price->convert($aRow['ref_user_amount']);
                        $total[AIN::getPhrase('adnetwork.ref_user_amount')] += ($aRow['ref_user_amount']);

						$display[AIN::getPhrase('adnetwork.system_amount')] = $price->convert($aRow['system_amount']);
                        $total[AIN::getPhrase('adnetwork.system_amount')] += ($aRow['system_amount']);
                    }

                    $display[AIN::getPhrase('adnetwork.ecpm')] = round(($aRow['spent_amount'] / $aRow['impression'] * 1000), 2);
                    $total[AIN::getPhrase('adnetwork.ecpm')] = '-';


                    $table->add($display);
                }
                $table->add($total);
                $table->tfoot();
                break;

            case 'get_spent_daily':
                $total = array();
                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    $display = [];

                    //$dateArray = $date->getArray($aRow['day']);
                    //$display[AIN::getPhrase('adnetwork.day')] 					= "{$dateArray['day']}.{$dateArray['month']}.{$dateArray['year']}";

                    $display[AIN::getPhrase('adnetwork.day')] = $aRow['day'];
                    $total[AIN::getPhrase('adnetwork.day')] = '-';

                    $display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['impression']);
                    $total[AIN::getPhrase('adnetwork.impression')] += $aRow['impression'];

                    $display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['click']);
                    $total[AIN::getPhrase('adnetwork.click')] += ($aRow['click']);

                    $display[AIN::getPhrase('adnetwork.unique_impression')] = number_format($aRow['unique_impression']);
                    $total[AIN::getPhrase('adnetwork.unique_impression')] += ($aRow['unique_impression']);

                    $display[AIN::getPhrase('adnetwork.reach')] = number_format($aRow['reach']);
                    $total[AIN::getPhrase('adnetwork.reach')] = '-';


                    $display[AIN::getPhrase('adnetwork.unique_click')] = number_format($aRow['unique_click']);
                    $total[AIN::getPhrase('adnetwork.unique_click')] += ($aRow['unique_click']);

                    if ($aRow['video_start'] > 0) {
                        $display[AIN::getPhrase('adnetwork.video_start')] = number_format($aRow['video_start']);
                        $total[AIN::getPhrase('adnetwork.video_start')] += ($aRow['video_start']);
                    }
                    if ($aRow['firstQuartile'] > 0) {
                        $display[AIN::getPhrase('adnetwork.firstquartile')] = number_format($aRow['firstQuartile']);
                        $total[AIN::getPhrase('adnetwork.firstquartile')] += ($aRow['firstQuartile']);
                    }
                    if ($aRow['midpoint'] > 0) {
                        $display[AIN::getPhrase('adnetwork.midpoint')] = number_format($aRow['midpoint']);
                        $total[AIN::getPhrase('adnetwork.midpoint')] += ($aRow['midpoint']);
                    }
                    if ($aRow['thirdQuartile'] > 0) {
                        $display[AIN::getPhrase('adnetwork.thirdquartile')] = number_format($aRow['thirdQuartile']);
                        $total[AIN::getPhrase('adnetwork.thirdquartile')] += ($aRow['thirdQuartile']);
                    }
                    if ($aRow['complete'] > 0) {
                        $display[AIN::getPhrase('adnetwork.complete')] = number_format($aRow['complete']);
                        $total[AIN::getPhrase('adnetwork.complete')] += ($aRow['complete']);
                    }

                    $display[AIN::getPhrase('adnetwork.spent_amount')] = $price->convert($aRow['spent_amount']);
                    $total[AIN::getPhrase('adnetwork.spent_amount')] += ($aRow['spent_amount']);

                    $table->add($display);
                }
                $table->add($total);
                $table->tfoot();
                break;

            case 'get_revenue_ad':
                $total = array();
                $static = AIN::getService('video.func.static')->get();
                $dimension = [];
                foreach (AIN::getService('video.func.static')->get_static_dimension(['is_active' => 1]) as $aOptionsR) {
                    $dimension[$aOptionsR['id']] = "{$aOptionsR['width']}x{$aOptionsR['height']}";
                }
                $dimension['30'] = AIN::getPhrase('adnetwork.ad_static_dimension_name_30');

                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    if ($aRow['site_impression'] <= 1) {
                        continue;
                    }

                    $display = [];

                    if (getGroupParam('adnetwork.can_manage_advertiser_all')) {
                        $display[AIN::getPhrase('adnetwork.ad_id')] = $aRow['ad_id'];
                        $total[AIN::getPhrase('adnetwork.ad_id')] = '-';

                        $display[AIN::getPhrase('adnetwork.name')] = $aRow['name'];
                        $total[AIN::getPhrase('adnetwork.name')] = '-';
                    } else {
                        $ad_info = AIN::getService('video')->get_ad($where['id'] = $aRow['ad_id']);
                        $campaign_info = AIN::getService('video')->get_campaign(['campaign_id' => $ad_info['data']['rows'][0]['campaign_id']]);

                        $display[AIN::getPhrase('adnetwork.campaign_id')] = $campaign_info['data']['rows'][0]['campaign_id'];
                        $total[AIN::getPhrase('adnetwork.campaign_id')] = '-';

                        $display[AIN::getPhrase('adnetwork.campaign_name')] = $campaign_info['data']['rows'][0]['name'];
                        $total[AIN::getPhrase('adnetwork.campaign_name')] = '-';
                    }

                    $display[AIN::getPhrase('adnetwork.model_id')] = $static[$aRow['model_id']];
                    if ($aRow['model_id'] == 4) {
                        $display[AIN::getPhrase('adnetwork.model_id')] .= '(' . AIN::getPhrase("adnetwork.{$aRow['cpv']}") . '})';
                    }
                    $total[AIN::getPhrase('adnetwork.model_id')] = '-';

                    $display[AIN::getPhrase('adnetwork.dimension_id')] = $dimension[$aRow['dimension_id']];
                    $total[AIN::getPhrase('adnetwork.dimension_id')] = '';

                    $display[AIN::getPhrase('adnetwork.site_impression')] = number_format($aRow['site_impression']);
                    $total[AIN::getPhrase('adnetwork.site_impression')] += ($aRow['site_impression']);

                    $display[AIN::getPhrase('adnetwork.site_click')] = number_format($aRow['site_click']);
                    $total[AIN::getPhrase('adnetwork.site_click')] += ($aRow['site_click']);

                    $display[AIN::getPhrase('adnetwork.ecpm')] = round(($aRow['publisher_amount'] / $aRow['site_impression'] * 1000), 2);
                    $total[AIN::getPhrase('adnetwork.ecpm')] = '-';

                    if ($aRow['site_click'] > 0) {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = round(($aRow['publisher_amount'] / $aRow['site_click']), 2);
                    } else {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = 0;
                    }
                    $total[AIN::getPhrase('adnetwork.ecpc')] = '-';

                    $display[AIN::getPhrase('adnetwork.ctr')] = number_format(($aRow['site_click'] / $aRow['site_impression']) * 100, 2) . '%';
                    $total[AIN::getPhrase('adnetwork.ctr')] = '-';

                    if ($aRow['video_start'] > 0) {
                        $display[AIN::getPhrase('adnetwork.video_start')] = number_format($aRow['video_start']);
                        $total[AIN::getPhrase('adnetwork.video_start')] += ($aRow['video_start']);
                    }
                    if ($aRow['firstQuartile'] > 0) {
                        $display[AIN::getPhrase('adnetwork.firstquartile')] = number_format($aRow['firstQuartile']);
                        $total[AIN::getPhrase('adnetwork.firstquartile')] += ($aRow['firstQuartile']);
                    }
                    if ($aRow['midpoint'] > 0) {
                        $display[AIN::getPhrase('adnetwork.midpoint')] = number_format($aRow['midpoint']);
                        $total[AIN::getPhrase('adnetwork.midpoint')] += ($aRow['midpoint']);
                    }
                    if ($aRow['thirdQuartile'] > 0) {
                        $display[AIN::getPhrase('adnetwork.thirdquartile')] = number_format($aRow['thirdQuartile']);
                        $total[AIN::getPhrase('adnetwork.thirdquartile')] += ($aRow['thirdQuartile']);
                    }
                    if ($aRow['complete'] > 0) {
                        $display[AIN::getPhrase('adnetwork.complete')] = number_format($aRow['complete']);
                        $total[AIN::getPhrase('adnetwork.complete')] += ($aRow['complete']);
                    }

                    $display[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($aRow['publisher_amount']);
                    $total[AIN::getPhrase('adnetwork.publisher_amount')] += ($aRow['publisher_amount']);

                    $table->add($display);
                }
                $table->add($total);
                $table->tfoot();
                break;

            case 'get_revenue_ad_model':
                $total = array();
                $static = AIN::getService('video.func.static')->get();
                $dimension = [];
                foreach (AIN::getService('video.func.static')->get_static_dimension(['is_active' => 1]) as $aOptionsR) {
                    $dimension[$aOptionsR['id']] = "{$aOptionsR['width']}x{$aOptionsR['height']}";
                }
                $dimension['30'] = AIN::getPhrase('adnetwork.ad_static_dimension_name_30');

                $calc = array('impression', 'unique_impression', 'click', 'unique_click', 'site_impression', 'site_click', 'video_start', 'firstQuartile', 'midpoint', 'thirdQuartile', 'complete', 'publisher_amount');

                $aTotal = array();
                $vTotal = array();

                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    foreach ($aRow as $key2 => $aRow2) {
                        if (in_array($key2, $calc)) {
                            $tkey = $static[$aRow['model_id']];
                            if ($aRow['model_id'] == 4) {
                                //$tkey .= "({$aRow['cpv']})";

                                $aRow['cpv'] = str_replace('start', '0', $aRow['cpv']);
                                $aRow['cpv'] = str_replace('firstQuartile', '25', $aRow['cpv']);
                                $aRow['cpv'] = str_replace('complete', '100', $aRow['cpv']);
                                $aRow['cpv'] = str_replace('midpoint', '50', $aRow['cpv']);
                                $aRow['cpv'] = str_replace('thirdQuartile', '75', $aRow['cpv']);

                                $vTotal[$aRow['cpv']][$key2] += $aRow2;
                            }

                            $aTotal[$tkey][$key2] += $aRow2;
                        }
                    }
                }

                ksort($aTotal);
                ksort($vTotal);

                foreach ($aTotal as $key => $aRow) {
                    $display = [];
                    $display[AIN::getPhrase('adnetwork.model_id')] = $key;
                    $total[AIN::getPhrase('adnetwork.model_id')] = '-';

                    $display[AIN::getPhrase('adnetwork.site_impression')] = number_format($aRow['site_impression']);
                    $total[AIN::getPhrase('adnetwork.site_impression')] += ($aRow['site_impression']);

                    $display[AIN::getPhrase('adnetwork.site_click')] = number_format($aRow['site_click']);
                    $total[AIN::getPhrase('adnetwork.site_click')] += ($aRow['site_click']);

					$display[AIN::getPhrase('adnetwork.video_start')] = number_format($aRow['video_start']);
					$total[AIN::getPhrase('adnetwork.video_start')] += ($aRow['video_start']);

					$display[AIN::getPhrase('adnetwork.firstquartile')] = number_format($aRow['firstQuartile']);
					$total[AIN::getPhrase('adnetwork.firstquartile')] += ($aRow['firstQuartile']);

					$display[AIN::getPhrase('adnetwork.midpoint')] = number_format($aRow['midpoint']);
					$total[AIN::getPhrase('adnetwork.midpoint')] += ($aRow['midpoint']);

					$display[AIN::getPhrase('adnetwork.thirdquartile')] = number_format($aRow['thirdQuartile']);
					$total[AIN::getPhrase('adnetwork.thirdquartile')] += ($aRow['thirdQuartile']);

					$display[AIN::getPhrase('adnetwork.complete')] = number_format($aRow['complete']);
					$total[AIN::getPhrase('adnetwork.complete')] += ($aRow['complete']);

                    $display[AIN::getPhrase('adnetwork.ecpm')] = round(($aRow['publisher_amount'] / $aRow['site_impression'] * 1000), 2);
                    $total[AIN::getPhrase('adnetwork.ecpm')] = '-';

                    if ($aRow['site_click'] > 0) {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = round(($aRow['publisher_amount'] / $aRow['site_click']), 2);
                    } else {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = 0;
                    }
                    $total[AIN::getPhrase('adnetwork.ecpc')] = '-';

                    $display[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($aRow['publisher_amount']);
                    $total[AIN::getPhrase('adnetwork.publisher_amount')] += ($aRow['publisher_amount']);

                    $table->add($display);
                }

                /*
                foreach ($vTotal as $key => $aRow) {
                    $display = [];
                    $display[AIN::getPhrase('adnetwork.model_id')] = "--CPV($key)";
                    $display[AIN::getPhrase('adnetwork.site_impression')] = number_format($aRow['site_impression']);
                    $display[AIN::getPhrase('adnetwork.site_click')] = number_format($aRow['site_click']);

                    $display[AIN::getPhrase('adnetwork.video_start')] = number_format($aRow['video_start']);
                    $display[AIN::getPhrase('adnetwork.firstquartile')] = number_format($aRow['firstQuartile']);
                    $display[AIN::getPhrase('adnetwork.midpoint')] = number_format($aRow['midpoint']);
                    $display[AIN::getPhrase('adnetwork.thirdquartile')] = number_format($aRow['thirdQuartile']);
                    $display[AIN::getPhrase('adnetwork.complete')] = number_format($aRow['complete']);
                    $display[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($aRow['publisher_amount']);

                    $table->add($display);
                }
                */

                $table->add($total);
                $table->tfoot();
                break;


			case 'get_spent_user_v2':
				$total = array();
				foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
					$display = array();

				    $display[AIN::getPhrase('adnetwork.intime')] 		= date('d.m.Y', strtotime($aRow['intime']));
                    $total[AIN::getPhrase('adnetwork.intime')] 			= '';

					$display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['impression']);
                    $total[AIN::getPhrase('adnetwork.impression')] += ($aRow['impression']);

					$display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['click']);
                    $total[AIN::getPhrase('adnetwork.click')] += ($aRow['click']);

					//$display[AIN::getPhrase('adnetwork.reach')] = number_format($aRow['reach']);
                   //$total[AIN::getPhrase('adnetwork.reach')] += ($aRow['reach']);

					$display[AIN::getPhrase('adnetwork.spent_amount')] = $price->convert($aRow['wallet_spent_amount']);
                    $total[AIN::getPhrase('adnetwork.spent_amount')] += ($aRow['wallet_spent_amount']);


					//$display[AIN::getPhrase('adnetwork.wallet_spent_amount')]	= $price->convert($aRow['wallet_spent_amount']);
                    //$total[AIN::getPhrase('adnetwork.wallet_spent_amount')]		+= ($aRow['wallet_spent_amount']);


					$table->add($display);
				}
                $table->add($total);
                $table->tfoot();
			break;




			case 'traffic':
				foreach ($accounting_stats['data']['rows'] as $key => $aRow) {
					$display = array();

                    $display['ad_id'] 									= $aRow['ad_id'];
                    $display['slot_id'] 								= $aRow['slot_id'];
                    $display['method']							 		= $aRow['method'];

                    $display['hash'] 									= $aRow['hash'];
                    $display['country_id'] 								= $aRow['country_id'];
                    $display['ip'] 										= $aRow['ip'];

                    $display[AIN::getPhrase('adnetwork.page')] 			= $aRow['page'];
                    $display[AIN::getPhrase('adnetwork.ref_url')] 		= $aRow['ref_url'];
                    $display[AIN::getPhrase('adnetwork.device_id')] 	= $aRow['device_id'];
                    $display[AIN::getPhrase('adnetwork.os_id')] 		= $aRow['os_id'];

                    $display[AIN::getPhrase('adnetwork.intime')] 		= $aRow['intime'];

					$table->add($display);
				}
			break;


























            case 'get_revenue_site_archive':
				//print_r($where);
                $total = array();
                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    $display = [];

					$display[AIN::getPhrase('adnetwork.site_id')] = $aRow['site_id'];
					$total[AIN::getPhrase('adnetwork.site_id')] = '';

					$display[AIN::getPhrase('adnetwork.domain')] = $aRow['domain'];
					$total[AIN::getPhrase('adnetwork.domain')] = '';



                    $display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['impression']);
                    $total[AIN::getPhrase('adnetwork.impression')] += $aRow['impression'];

                    $display[AIN::getPhrase('adnetwork.unique_impression')] = number_format($aRow['unique_impression']);
                    $total[AIN::getPhrase('adnetwork.unique_impression')] += $aRow['unique_impression'];

                    $display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['click']);
                    $total[AIN::getPhrase('adnetwork.click')] += $aRow['click'];

                    $display[AIN::getPhrase('adnetwork.unique_click')] = number_format($aRow['unique_click']);
                    $total[AIN::getPhrase('adnetwork.unique_click')] += $aRow['unique_click'];


                    $display[AIN::getPhrase('adnetwork.ctr')] = number_format(($aRow['click'] / $aRow['impression']) * 100, 2) . '%';
                    $total[AIN::getPhrase('adnetwork.ctr')] = '-';

                    $display[AIN::getPhrase('adnetwork.site_impression')] = number_format($aRow['site_impression']);
                    $total[AIN::getPhrase('adnetwork.site_impression')] += $aRow['site_impression'];

					$display[AIN::getPhrase('adnetwork.site_click')] = number_format($aRow['site_click']);
                    $total[AIN::getPhrase('adnetwork.site_click')] += $aRow['site_click'];


					$display[AIN::getPhrase('adnetwork.reach')] = number_format($aRow['reach']);
                    $total[AIN::getPhrase('adnetwork.reach')] += $aRow['reach'];

					$display['Error'] = number_format($aRow['error']);
                    $total['Error'] += $aRow['error'];

					$display[AIN::getPhrase('adnetwork.video_start')] = number_format($aRow['video_start']);
                    $total[AIN::getPhrase('adnetwork.video_start')] += $aRow['video_start'];

					$display[AIN::getPhrase('adnetwork.firstquartile')] = number_format($aRow['firstQuartile']);
                    $total[AIN::getPhrase('adnetwork.firstquartile')] += $aRow['firstQuartile'];

					$display[AIN::getPhrase('adnetwork.midpoint')] = number_format($aRow['midpoint']);
                    $total[AIN::getPhrase('adnetwork.midpoint')] += $aRow['midpoint'];

					$display[AIN::getPhrase('adnetwork.thirdquartile')] = number_format($aRow['thirdQuartile']);
                    $total[AIN::getPhrase('adnetwork.thirdquartile')] += $aRow['thirdQuartile'];

					$display[AIN::getPhrase('adnetwork.complete')] = number_format($aRow['complete']);
                    $total[AIN::getPhrase('adnetwork.complete')] += $aRow['complete'];


                    $display[AIN::getPhrase('adnetwork.spent_amount')] = $price->convert($aRow['spent_amount']);
                    $total[AIN::getPhrase('adnetwork.spent_amount')] += $aRow['spent_amount'];

                    $display[AIN::getPhrase('adnetwork.wallet_spent_amount')] = $price->convert($aRow['wallet_spent_amount']);
                    $total[AIN::getPhrase('adnetwork.wallet_spent_amount')] += $aRow['wallet_spent_amount'];

					$display[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($aRow['publisher_amount']);
                    $total[AIN::getPhrase('adnetwork.publisher_amount')] += $aRow['publisher_amount'];

					$display[AIN::getPhrase('adnetwork.system_amount')] = $price->convert($aRow['system_amount']);
                    $total[AIN::getPhrase('adnetwork.system_amount')] += $aRow['system_amount'];

					$display[AIN::getPhrase('adnetwork.ref_user_amount')] = $price->convert($aRow['ref_user_amount']);
                    $total[AIN::getPhrase('adnetwork.ref_user_amount')] += $aRow['ref_user_amount'];

                    $display[AIN::getPhrase('adnetwork.ecpm')] = round(($aRow['spent_amount'] / $aRow['impression'] * 1000), 2);
                    $total[AIN::getPhrase('adnetwork.ecpm')] = '-';
                    if ($aRow['site_click'] > 0) {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = round(($aRow['spent_amount'] / $aRow['click']), 2);
                    } else {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = 0;
                    }
                    $total[AIN::getPhrase('adnetwork.ecpc')] = '-';

                    $table->add($display);
                }
                $table->add($total);
                $table->tfoot();
                break;








		case 'get_spent_ad_archive':
				$total = array();
                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    $display = [];

					$display[AIN::getPhrase('adnetwork.campaign_id')] = "<a href='".AIN::getLib('url')->makeUrl('ad.viewreports', array( 'val[stats_type]' => 'get_spent_ad', 'val[campaign_id]' => $aRow['campaign_id'],'val[start_date]' => $where['start_date'],'val[end_date]' => $where['end_date'],'val[val[date_select]]' => 0) )."' target='_blank'>{$aRow['campaign_id']}</a>";
					$total[AIN::getPhrase('adnetwork.campaign_id')] = '';

					$display[AIN::getPhrase('adnetwork.name')] = $aRow['name'];
					$total[AIN::getPhrase('adnetwork.name')] = '';


                    $display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['impression']);
                    $total[AIN::getPhrase('adnetwork.impression')] += $aRow['impression'];

                    $display[AIN::getPhrase('adnetwork.unique_impression')] = number_format($aRow['unique_impression']);
                    $total[AIN::getPhrase('adnetwork.unique_impression')] += $aRow['unique_impression'];

                    $display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['click']);
                    $total[AIN::getPhrase('adnetwork.click')] += $aRow['click'];

                    $display[AIN::getPhrase('adnetwork.unique_click')] = number_format($aRow['unique_click']);
                    $total[AIN::getPhrase('adnetwork.unique_click')] += $aRow['unique_click'];

                    $display[AIN::getPhrase('adnetwork.ctr')] = number_format(($aRow['click'] / $aRow['impression']) * 100, 2) . '%';
                    $total[AIN::getPhrase('adnetwork.ctr')] = '-';

					$display[AIN::getPhrase('adnetwork.reach')] = number_format($aRow['reach']);
                    $total[AIN::getPhrase('adnetwork.reach')] += $aRow['reach'];

					$display[AIN::getPhrase('adnetwork.video_start')] = number_format($aRow['video_start']);
                    $total[AIN::getPhrase('adnetwork.video_start')] += $aRow['video_start'];

					$display[AIN::getPhrase('adnetwork.firstquartile')] = number_format($aRow['firstQuartile']);
                    $total[AIN::getPhrase('adnetwork.firstquartile')] += $aRow['firstQuartile'];

					$display[AIN::getPhrase('adnetwork.midpoint')] = number_format($aRow['midpoint']);
                    $total[AIN::getPhrase('adnetwork.midpoint')] += $aRow['midpoint'];

					$display[AIN::getPhrase('adnetwork.thirdquartile')] = number_format($aRow['thirdQuartile']);
                    $total[AIN::getPhrase('adnetwork.thirdquartile')] += $aRow['thirdQuartile'];

					$display[AIN::getPhrase('adnetwork.complete')] = number_format($aRow['complete']);
                    $total[AIN::getPhrase('adnetwork.complete')] += $aRow['complete'];

                    $display[AIN::getPhrase('adnetwork.spent_amount')] = $price->convert($aRow['spent_amount']);
                    $total[AIN::getPhrase('adnetwork.spent_amount')] 	+= $aRow['spent_amount'];



				if ( getUserBy('user_group_id') == 1 ) {
                    $display[AIN::getPhrase('adnetwork.site_impression')] = number_format($aRow['site_impression']);
                    $total[AIN::getPhrase('adnetwork.site_impression')] += $aRow['site_impression'];

					$display[AIN::getPhrase('adnetwork.site_click')] = number_format($aRow['site_click']);
                    $total[AIN::getPhrase('adnetwork.site_click')] += $aRow['site_click'];

					$display['Error'] = number_format($aRow['error']);
                    $total['Error'] += $aRow['error'];

                    $display[AIN::getPhrase('adnetwork.wallet_spent_amount')] = $price->convert($aRow['wallet_spent_amount']);
                    $total[AIN::getPhrase('adnetwork.wallet_spent_amount')] += $aRow['wallet_spent_amount'];

					$display[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($aRow['publisher_amount']);
                    $total[AIN::getPhrase('adnetwork.publisher_amount')] += $aRow['publisher_amount'];

					$display[AIN::getPhrase('adnetwork.system_amount')] = $price->convert($aRow['system_amount']);
                    $total[AIN::getPhrase('adnetwork.system_amount')] += $aRow['system_amount'];

					$display[AIN::getPhrase('adnetwork.ref_user_amount')] = $price->convert($aRow['ref_user_amount']);
                    $total[AIN::getPhrase('adnetwork.ref_user_amount')] += $aRow['ref_user_amount'];
				}
                    $display[AIN::getPhrase('adnetwork.ecpm')] = round(($aRow['spent_amount'] / $aRow['impression'] * 1000), 2);
                    $total[AIN::getPhrase('adnetwork.ecpm')] = '-';
                    if ($aRow['site_click'] > 0) {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = round(($aRow['spent_amount'] / $aRow['click']), 2);
                    } else {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = 0;
                    }
                    $total[AIN::getPhrase('adnetwork.ecpc')] = '-';

                    $table->add($display);
                }
                $table->add($total);
                $table->tfoot();
                break;







		case 'get_ads_hourly':
				//print_r($where);
				$total = array();
                foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
                    $display = [];
										
					$display[AIN::getPhrase('adnetwork.hour')] = date('H:i', strtotime($aRow['intime']));
					$total[AIN::getPhrase('adnetwork.hour')] = '';
					
                    $display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['impression']);
                    $total[AIN::getPhrase('adnetwork.impression')] += $aRow['impression'];
					
                    $display[AIN::getPhrase('adnetwork.unique_impression')] = number_format($aRow['unique_impression']);
                    $total[AIN::getPhrase('adnetwork.unique_impression')] += $aRow['unique_impression'];

                    $display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['click']);
                    $total[AIN::getPhrase('adnetwork.click')] += $aRow['click'];

                    $display[AIN::getPhrase('adnetwork.unique_click')] = number_format($aRow['unique_click']);
                    $total[AIN::getPhrase('adnetwork.unique_click')] += $aRow['unique_click'];
					
                    $display[AIN::getPhrase('adnetwork.ctr')] = number_format(($aRow['click'] / $aRow['impression']) * 100, 2) . '%';
                    $total[AIN::getPhrase('adnetwork.ctr')] = '-';

		
				if ( getUserBy('user_group_id') == 1 ) {
                    $display[AIN::getPhrase('adnetwork.site_impression')] = number_format($aRow['site_impression']);
                    $total[AIN::getPhrase('adnetwork.site_impression')] += $aRow['site_impression'];

					$display[AIN::getPhrase('adnetwork.site_click')] = number_format($aRow['site_click']);
                    $total[AIN::getPhrase('adnetwork.site_click')] += $aRow['site_click'];

					$display['Error'] = number_format($aRow['error']);
                    $total['Error'] += $aRow['error'];

                    $display[AIN::getPhrase('adnetwork.wallet_spent_amount')] = $price->convert($aRow['wallet_spent_amount']);
                    $total[AIN::getPhrase('adnetwork.wallet_spent_amount')] += $aRow['wallet_spent_amount'];

					$display[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($aRow['publisher_amount']);
                    $total[AIN::getPhrase('adnetwork.publisher_amount')] += $aRow['publisher_amount'];

					$display[AIN::getPhrase('adnetwork.system_amount')] = $price->convert($aRow['system_amount']);
                    $total[AIN::getPhrase('adnetwork.system_amount')] += $aRow['system_amount'];

					$display[AIN::getPhrase('adnetwork.ref_user_amount')] = $price->convert($aRow['ref_user_amount']);
                    $total[AIN::getPhrase('adnetwork.ref_user_amount')] += $aRow['ref_user_amount'];
				}
					
					$display[AIN::getPhrase('adnetwork.ecpm')] = round(($aRow['spent_amount'] / $aRow['impression'] * 1000), 2);
                    $total[AIN::getPhrase('adnetwork.ecpm')] = '-';
                    if ($aRow['site_click'] > 0) {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = round(($aRow['spent_amount'] / $aRow['click']), 2);
                    } else {
                        $display[AIN::getPhrase('adnetwork.ecpc')] = 0;
                    }
                    $total[AIN::getPhrase('adnetwork.ecpc')] = '-';

                    $table->add($display);
                }
                $table->add($total);
                $table->tfoot();
                break;
				
				
				
				
				
				
		case 'ad_calculated_archive_month':
			//print_r($where);
			$total = array();
			foreach ($accounting_stats['data']['stats'] as $key => $aRow) {
				$display = [];
				
				$display[AIN::getPhrase('adnetwork.month')] = $aRow['month'];
				$total[AIN::getPhrase('adnetwork.month')] = '';
			
				$display[AIN::getPhrase('adnetwork.impression')] = number_format($aRow['impression']);
				$total[AIN::getPhrase('adnetwork.impression')] += $aRow['impression'];
				
				$display[AIN::getPhrase('adnetwork.unique_impression')] = number_format($aRow['unique_impression']);
				$total[AIN::getPhrase('adnetwork.unique_impression')] += $aRow['unique_impression'];
			
				$display[AIN::getPhrase('adnetwork.click')] = number_format($aRow['click']);
				$total[AIN::getPhrase('adnetwork.click')] += $aRow['click'];

				$display[AIN::getPhrase('adnetwork.unique_click')] = number_format($aRow['unique_click']);
				$total[AIN::getPhrase('adnetwork.unique_click')] += $aRow['unique_click'];
				
				$display[AIN::getPhrase('adnetwork.ctr')] = number_format(($aRow['click'] / $aRow['impression']) * 100, 2) . '%';
				$total[AIN::getPhrase('adnetwork.ctr')] = '-';
				
				$display[AIN::getPhrase('adnetwork.site_impression')] = number_format($aRow['site_impression']);
				$total[AIN::getPhrase('adnetwork.site_impression')] += $aRow['site_impression'];

				$display[AIN::getPhrase('adnetwork.site_click')] = number_format($aRow['site_click']);
				$total[AIN::getPhrase('adnetwork.site_click')] += $aRow['site_click'];		
				
				
				$display[AIN::getPhrase('adnetwork.spent_amount')] = $price->convert($aRow['spent_amount']);
				$total[AIN::getPhrase('adnetwork.spent_amount')] += $aRow['spent_amount'];
						
				$display[AIN::getPhrase('adnetwork.wallet_spent_amount')] = $price->convert($aRow['wallet_spent_amount']);
				$total[AIN::getPhrase('adnetwork.wallet_spent_amount')] += $aRow['wallet_spent_amount'];
			
				$display[AIN::getPhrase('adnetwork.bonus_amount')] = $price->convert( ($aRow['spent_amount'] - $aRow['wallet_spent_amount']) );
				$total[AIN::getPhrase('adnetwork.bonus_amount')] += ($aRow['spent_amount'] - $aRow['wallet_spent_amount']);
			
				$display[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($aRow['publisher_amount']);
				$total[AIN::getPhrase('adnetwork.publisher_amount')] += $aRow['publisher_amount'];
				
				$display[AIN::getPhrase('adnetwork.system_amount')] = $price->convert($aRow['system_amount']);
				$total[AIN::getPhrase('adnetwork.system_amount')] += $aRow['system_amount'];
				
				$display[AIN::getPhrase('adnetwork.ref_user_amount')] = $price->convert($aRow['ref_user_amount']);
				$total[AIN::getPhrase('adnetwork.ref_user_amount')] += $aRow['ref_user_amount'];		
			
				$table->add($display);
			}			
			$total[AIN::getPhrase('adnetwork.impression')] = number_format($total[AIN::getPhrase('adnetwork.impression')]);
			$total[AIN::getPhrase('adnetwork.unique_impression')] = number_format($total[AIN::getPhrase('adnetwork.unique_impression')]);
			$total[AIN::getPhrase('adnetwork.click')] = number_format($total[AIN::getPhrase('adnetwork.click')]);
			$total[AIN::getPhrase('adnetwork.unique_click')] = number_format($total[AIN::getPhrase('adnetwork.unique_click')]);
			$total[AIN::getPhrase('adnetwork.site_impression')] = number_format($total[AIN::getPhrase('adnetwork.site_impression')]);
			$total[AIN::getPhrase('adnetwork.site_click')] = number_format($total[AIN::getPhrase('adnetwork.site_click')]);
			
			$total[AIN::getPhrase('adnetwork.spent_amount')] = $price->convert($total[AIN::getPhrase('adnetwork.spent_amount')]);
			$total[AIN::getPhrase('adnetwork.wallet_spent_amount')] = $price->convert($total[AIN::getPhrase('adnetwork.wallet_spent_amount')]);
			$total[AIN::getPhrase('adnetwork.publisher_amount')] = $price->convert($total[AIN::getPhrase('adnetwork.publisher_amount')]);
			$total[AIN::getPhrase('adnetwork.system_amount')] = $price->convert($total[AIN::getPhrase('adnetwork.system_amount')]);
			$total[AIN::getPhrase('adnetwork.ref_user_amount')] = $price->convert($total[AIN::getPhrase('adnetwork.ref_user_amount')]);
			$total[AIN::getPhrase('adnetwork.bonus_amount')] = $price->convert($total[AIN::getPhrase('adnetwork.bonus_amount')]);
			$table->add($total);
			$table->tfoot();
			break;
			break;













        }


        $this->template()->assign(['aTables' => $table->execute()]);
        $this->template()->assign(array('aForms' => $aForms));
    }
}
