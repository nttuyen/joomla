function submitbutton(task)
{
    var form = $('poll-form');
    
    if (task == '')
    {
        return false;
    }
        
    if (task != 'poll.cancel' && task != 'poll.close')
    {
         
        /**                        
        * check if title is entered
        */
        
        var title = $('jform_title');
        if (title.value == '')
        {
            title.focus(); 
            title.addClass('invalid'); 
            title.getPrevious('label').addClass('invalid'); 
            alert(Joomla.JText._('Error_Correct_Title', 'Please add title'));
            
            return false;       
        } 
            
        /**
        * check for correct lag time (must be greater than zero)
        */
        
        var lag = $('jform_lag');
        if (lag.value == '')
        {
            lag.focus(); 
            lag.addClass('invalid'); 
            lag.getPrevious('label').addClass('invalid'); 
            alert(Joomla.JText._('Error_Add_Lag', 'Please add lag time'));
            
            return false;       
        }
        if (parseFloat(lag.value) == 0 )
        {
            lag.focus(); 
            lag.addClass('invalid'); 
            lag.getPrevious('label').addClass('invalid'); 
            alert(Joomla.JText._('Error_Correct_Lag', 'Lag time must be greater than 0'));
            
            return false;       
        }
        
        /**
        * check if publish_up date is before publish_down date  
        */
        
        var publish_up   = $('jform_publish_up');
        var publish_down = $('jform_publish_down');
        
        var publish_up_Val   = parseInt(publish_up.value.replace(/[ :-]/g,''));
        var publish_down_Val = parseInt(publish_down.value.replace(/[ :-]/g,''));

        if ( publish_up_Val >= publish_down_Val ) 
        {
            publish_up.addClass('invalid');
            publish_up.getPrevious('label').addClass('invalid');
            publish_down.addClass('invalid');
            publish_down.getPrevious('label').addClass('invalid');
                        
            alert(Joomla.JText._('Error_Correct_Publish_Dates', 'Please correct the start or end date of the poll'));
            $('jform_publish_down').focus();
            return false;
        }          
        
        /**
        * check for text in the first two options
        */
        
        var poll_options = $$('input[name^=poll_option]');
        
        for (i = 0; i < 2; i++) 
        {
            var option = poll_options[i];
            if (option.value == '') 
            {
                option.addClass('invalid');
                alert(Joomla.JText._('Error_Enter_Option_Text', 'Please enter option text'));
                option.focus();
                return false;
            }
        
        }
        
    }
        submitform(task);
        return true;    
}
