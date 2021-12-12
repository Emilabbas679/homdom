<div class="main_center">
    <ul>
        <li><a href="{{ url link='profile.offers' }}" class=" <?= AIN::getService('homdom.helpers')->checkActiveRoute('profile/offers')?>">{{phrase var='homdom.my_offers'}} </a> </li>
        <li><a href="{{ url link='profile.balance' }}" class=" <?= AIN::getService('homdom.helpers')->checkActiveRoute('profile/balance')?>">{{phrase var='homdom.balance'}} </a> </li>
        <li><a href="{{ url link='profile.history' }}" class=" <?= AIN::getService('homdom.helpers')->checkActiveRoute('profile/history')?>">{{phrase var='homdom.history'}} </a> </li>
        <li><a href="{{ url link='profile.favorites' }}" class=" <?= AIN::getService('homdom.helpers')->checkActiveRoute('profile/favorites')?>">{{phrase var='homdom.favorites'}} </a> </li>
        <li><a href="{{ url link='profile.reports' }}" class=" <?= AIN::getService('homdom.helpers')->checkActiveRoute('profile/reports')?>">{{phrase var='homdom.reports'}} </a> </li>
        <li><a href="{{ url link='profile.parameters' }}" class=" <?= AIN::getService('homdom.helpers')->checkActiveRoute('profile/parameters')?>" >{{phrase var='homdom.settings'}} </a> </li>
    </ul>
</div>