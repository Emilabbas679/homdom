<?php

defined('AIN') or exit('NO DICE!');

class apanel_service_menu extends AIN_Service
{
    private $aMenus = [];

    public function __construct()
    {
        $adv = AIN::getLib('session')->get('sPanelControllerName');


/*
        if ($adv == 'advertiser'):
        $sRoot = AIN::getPhrase('global.statistics');
        $this->aMenus[$sRoot] = [
            AIN::getPhrase('adnetwork.campaign_statistics') => AIN::getLib('url')->makeUrl('statistics.campaign', []),
            AIN::getPhrase('adnetwork.campaign_formats_statistics') => AIN::getLib('url')->makeUrl('statistics.campaignformat', []),
            //AIN::getPhrase('adnetwork.demographic_statistics') => AIN::getLib('url')->makeUrl('statistics.demography', []),
            //AIN::getPhrase('adnetwork.geographic_statistics') => AIN::getLib('url')->makeUrl('statistics.geo', []),
            AIN::getPhrase('adnetwork.spent_statistics') => AIN::getLib('url')->makeUrl('statistics.spent', []),
            AIN::getPhrase('adnetwork.tech_stats') => AIN::getLib('url')->makeUrl('statistics.technology', []),
            //AIN::getPhrase('adnetwork.website_statistics') => AIN::getLib('url')->makeUrl('statistics.website', []),
        ];
        endif;

*/

        $root = AIN::getPhrase('user.profile_title');

        if ($adv == 'advertiser') {
            $this->aMenus[$root] = [
                AIN::getPhrase('user.profile') => AIN::getLib('url')->makeUrl('profiles.index', []),
                AIN::getPhrase('user.notifications') => AIN::getLib('url')->makeUrl('profiles.notifications', []),
                AIN::getPhrase('user.members.index') => AIN::getLib('url')->makeUrl('user.members.index', []),
            ];
        } else {
            $this->aMenus[$root] = [
                AIN::getPhrase('user.profile') => AIN::getLib('url')->makeUrl('publisher.profiles.index', []),
                AIN::getPhrase('user.notifications') => AIN::getLib('url')->makeUrl('publisher.profiles.notifications', []),
                AIN::getPhrase('adnetwork.publisher_payments') => AIN::getLib('url')->makeUrl('publisher.profiles.payments', []),
            ];
        }

        if (1 == getUserBy('user_group_id')) {
            $root = AIN::getPhrase('adnetwork.admincp');
            $this->aMenus[$root] = [
                AIN::getPhrase('adnetwork.priority') => AIN::getLib('url')->makeUrl('ad.priority.index', []),

                AIN::getPhrase('adnetwork.country') => AIN::getLib('url')->makeUrl('video.core.country', []),


                AIN::getPhrase('adnetwork.currencies') => AIN::getLib('url')->makeUrl('video.core.currencies', []),

                AIN::getPhrase('language.language_phrase') => AIN::getLib('url')->makeUrl('language.phrase.index', []),
                AIN::getPhrase('language.language_phrase') => AIN::getLib('url')->makeUrl('language.phrase.index', []),

                AIN::getPhrase('adnetwork.get_user_group') => AIN::getLib('url')->makeUrl('user.group.index', []),
                AIN::getPhrase('adnetwork.get_user_group_create') => AIN::getLib('url')->makeUrl('user.group.add', []),

                AIN::getPhrase('adnetwork.user_group_setting_add') => AIN::getLib('url')->makeUrl('user.group.setadd', []),


                AIN::getPhrase('adnetwork.get_user') => AIN::getLib('url')->makeUrl('video.user.index', []),
                AIN::getPhrase('adnetwork.user_create') => AIN::getLib('url')->makeUrl('video.user.add', []),
                AIN::getPhrase('adnetwork.get_user_publisher') => AIN::getLib('url')->makeUrl('video.user.publishers', []),
                AIN::getPhrase('adnetwork.get_user_advertiser') => AIN::getLib('url')->makeUrl('video.user.advertisers', []),

                AIN::getPhrase('adnetwork.members') => AIN::getLib('url')->makeUrl('user.members.index', []),

                AIN::getPhrase('adnetwork.setting') => AIN::getLib('url')->makeUrl('user.group.setting', []),



                AIN::getPhrase('adnetwork.history') => AIN::getLib('url')->makeUrl('history', []),

                AIN::getPhrase('adnetwork.wallet_list') => AIN::getLib('url')->makeUrl('ad.wallet.list', []),
				
				
                AIN::getPhrase('adnetwork.send_mail_log') => AIN::getLib('url')->makeUrl('admincp.mail.log', []),

            ];
        }

        if (getGroupParam('adnetwork.can_manage_accounting')) {
            
			
			$root = AIN::getPhrase('adnetwork.accounting_2');
            $this->aMenus[$root] = [
			
			
                AIN::getPhrase('adnetwork.agency') => AIN::getLib('url')->makeUrl('video.agency.index', []),
                AIN::getPhrase('adnetwork.agency_create') => AIN::getLib('url')->makeUrl('video.agency.add', []),
				
                AIN::getPhrase('adnetwork.get_cost_category') => AIN::getLib('url')->makeUrl('finance.cost.category-index', []),
                AIN::getPhrase('adnetwork.create_cost_category') => AIN::getLib('url')->makeUrl('finance.cost.category-add', []),

                AIN::getPhrase('adnetwork.bank_transactions_index') 	=> AIN::getLib('url')->makeUrl('bank.transactions.index', []),
                AIN::getPhrase('adnetwork.bank_transactions_debit') 	=> AIN::getLib('url')->makeUrl('bank.transactions.debit', []),
                AIN::getPhrase('adnetwork.bank_transactions_credit') 	=> AIN::getLib('url')->makeUrl('bank.transactions.credit', []),

                AIN::getPhrase('adnetwork.ad_calculated_archive_month') => AIN::getLib('url')->makeUrl('accounting.reports', []),
                AIN::getPhrase('adnetwork.finance_receiveables') 		=> AIN::getLib('url')->makeUrl('finance.receiveables.index', []),		  
           ];


			
			
			
			
			
			
			$root = AIN::getPhrase('adnetwork.accounting');
            $this->aMenus[$root] = [
                AIN::getPhrase('adnetwork.accounting') => AIN::getLib('url')->makeUrl('accounting.index', []),
                AIN::getPhrase('adnetwork.finance_ad') => AIN::getLib('url')->makeUrl('finance.ad', []),


                //AIN::getPhrase('adnetwork.finance_advertiser') => AIN::getLib('url')->makeUrl('finance.advertiser', []),
                ///AIN::getPhrase('adnetwork.finance_publisher') => AIN::getLib('url')->makeUrl('finance.publisher', []),





                AIN::getPhrase('adnetwork.staffs') => AIN::getLib('url')->makeUrl('staff.index', []),



                AIN::getPhrase('adnetwork.get_cost') => AIN::getLib('url')->makeUrl('finance.cost.index', []),
                AIN::getPhrase('adnetwork.create_cost') => AIN::getLib('url')->makeUrl('finance.cost.add', []),


                AIN::getPhrase('adnetwork.finance_spending') => AIN::getLib('url')->makeUrl('finance.spending', []),
                AIN::getPhrase('adnetwork.invoice_forms') => AIN::getLib('url')->makeUrl('invoice.form', []),

                AIN::getPhrase('adnetwork.finance_receiveables_agency') => AIN::getLib('url')->makeUrl('finance.receiveables.agency', []),
                AIN::getPhrase('adnetwork.finance_receiveables_exchange') => AIN::getLib('url')->makeUrl('finance.receiveables.exchange', []),
                //AIN::getPhrase('adnetwork.finance_receiveables_add') => AIN::getLib('url')->makeUrl('finance.receiveables.add', []),


                AIN::getPhrase('adnetwork.finance_receiveables_log') => AIN::getLib('url')->makeUrl('finance.receiveables.log', []),
                AIN::getPhrase('adnetwork.finance_payables') => AIN::getLib('url')->makeUrl('finance.payables.index', []),
                AIN::getPhrase('adnetwork.finance_payment_log') => AIN::getLib('url')->makeUrl('finance.payables.log', []),
                AIN::getPhrase('adnetwork.finance_archive') => AIN::getLib('url')->makeUrl('finance.archive.index', []),
                AIN::getPhrase('adnetwork.finance_archive_edit') => AIN::getLib('url')->makeUrl('finance.archive.add', []),





                AIN::getPhrase('adnetwork.finance_transactions') => AIN::getLib('url')->makeUrl('finance.transactions.index', []),
                AIN::getPhrase('adnetwork.finance_transactions_add') => AIN::getLib('url')->makeUrl('finance.transactions.add', []),
                AIN::getPhrase('adnetwork.balance') => AIN::getLib('url')->makeUrl('finance.balance', []),

           ];








            $root = AIN::getPhrase('adnetwork.ssp');
            $this->aMenus[$root] = [
                 AIN::getPhrase('adnetwork.get_ssp') => AIN::getLib('url')->makeUrl('ssp.website.index', []),
                 AIN::getPhrase('adnetwork.create_ssp') => AIN::getLib('url')->makeUrl('ssp.website.add', []),
           ];
		   
		   
            $root = AIN::getPhrase('adnetwork.service_players');
            $this->aMenus[$root] = [
                 AIN::getPhrase('adnetwork.get_players') => AIN::getLib('url')->makeUrl('service.players.index', []),
                 AIN::getPhrase('adnetwork.player_create') => AIN::getLib('url')->makeUrl('service.players.add', []),
           ];
		   
		   
		   
		   
		   
		   
		   
		   
        }
    }

    public function get()
    {
        return $this->aMenus;
    }
}
