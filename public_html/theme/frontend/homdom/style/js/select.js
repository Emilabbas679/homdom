

 $(document).ready(function(){
  
    var $select = $('select.select-regist'),
        $speed = 'fast';
    
    $select.each(function(){
      // Allow default browser styling
      if ( $(this).hasClass('default') ) {
        return;
      }
      $(this).css('display', 'none');
      // Generate fancy select box
      $(this).after('<ul class="fancy-select" style="display: none;"></ul>');
      var $current = $(this),
          $fancy = $current.next('.fancy-select');
      
      // Get options
      var $options = $(this).find('option');
      $options.each(function(index){
        var $val = $(this).val(),
            $text = $(this).text(),
            $disabled = '';
        // Add class for disabled options
        if ( $(this).attr('disabled') ) $disabled = ' disabled';      
        
        if ( index == 0 ) {
          // Create clickable object from first option
          $fancy.before('<span class="selected" data-val="'+ $val +'">'+ $text +'</span>');
        }
        // Load all options into fake dropdown
        $fancy.append('<li class="fancy-option'+ $disabled +'" data-val="'+ $val +'"><span class="slct_icons"> </span>'+ $text +'</li>');
        // Update fake select box if this option is selected
        if ( $(this).attr('selected') ) {
          $(this).parent('select').val($val);
          $(this).parent('select').next('.selected').attr('data-val', $val).text($text);
        }
      });
      
    });
    
    // Show/hide options on click
    $('.selected').click(function(target){
      var $box = $(this).next('.fancy-select'),
          $target = target,
          $object = $(this);
          var $sp_slct = $(this);
      // Prevent multiple open select boxes
      if ( $box.is(':visible') ) {
        $box.slideUp($speed);
        
        $sp_slct.removeClass("sp_rotate");
        return;
      } else {
        $('.fancy-select').slideUp();
        $box.slideDown($speed);
  
        $sp_slct.addClass("sp_rotate");
      }
      
      // Click outside select box closes it
      $target.stopPropagation();
      if ( $box.css('display') !== 'none' ) {
        $(document).click(function(){
          $box.slideUp($speed);
          $sp_slct.removeClass("sp_rotate");
        });
      }
    });
    
    // Make selection
    $('.fancy-option').click(function(){
      var $val = $(this).attr('data-val'),
          $text = $(this).text(),
          $box = $(this).parent('.fancy-select'),
          $selected = $box.prev('.selected'),
          $disabled = $(this).hasClass('disabled');
      
      // Basic disabled option functionality
      if ( $disabled ) {
        return;
      }
      
      $box.slideUp($speed);
      
      // Update select object's value
      // and the fake box's "value"
      $selected.prev('select').val($val);
      $selected.attr('data-val', $val).text($text);
      
      
    });
    
  });