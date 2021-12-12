<?php $page = $this->_aVars['page']; ?>

<?=$page['content']?>




@section('js')
<?=$this->_aVars['page']['custom_js']?>

@endsection


@section('css')
<?=$this->_aVars['page']['custom_css']?>

@endsection