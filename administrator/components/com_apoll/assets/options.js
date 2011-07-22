/**
 * aPoll Voting Component
 *
 * @version     $Id$
 * @package     Joomla
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */
window.addEvent('domready', function() 
{

    //make labels sortable
    var labels = new Sortables($('apoll_options_holder'), 
    {
            revert: {
                transition: 'elastic:out'
                    },
            constrain : true,
            clone: true,
            handle: '.handle',
            onStart: function(el) {
                el.setStyle('background-color', '#f3f3f3');
            },
            onSort: function(el) {
                el.highlight('#f5f5f5');
            },
            onComplete: function(el){
                el.setStyle('background-color', '#fff');
                updateOrdering();
            }
    });
    
    
    // add event to add_option_Btn
    
    $('add_option_Btn').addEvent('click', function(e)
    {
        addOption($$('.apoll_option_labels').getLast('label'));        

    }); 
    
    // add events to the keydown event
    // if enter key is hit insert new option
    
    $$('.inputbox').addEvent('keydown', function(e) 
    {
        if(e.key == 'enter') {
            addOption(this.getParent());
        }
    });
        
    // add delete event on each delete button
    // add logic to the event 
       
    $$('.delete_me').each( function(e, i) 
    {
        e.addEvent('click', function(d) {
                delete_me(this);
            });
        }); 
    
    /**
    * method to delete parent elements
    */
       
    function delete_me(el) 
    {
        
        //check if there are at least 2 elements left
        var total_labels = $$('.apoll_option_labels').length;
        
        //if options are less than two raise alert
        if (total_labels <= 2) {
            alert(Joomla.JText._('COM_APOLL_CANT_DELETE_LESS_THAN_2_OPTIONS'));
        
        //if more continue with deletion
        } 
        else 
        {
                //initiate the variables
                var parent = el.getParent('label');
                parent.setStyle('background-color', '#FFCFD1');
                //get the id of the Delete_Button passed in the rel attribute
                var id = (el.get('rel'));
                //get the option input's value (2nd previous element) 
                var previous = el.getPrevious();
                var option_value = previous.getPrevious().value;
                //DEBUG
                //alert(option_value);
                
                // check if we have value in option input
                // if true, we will need a confirmation to delete
                var confirmation = (option_value == '') ? true : false;
                    
                // if option value is not empty ask for confirmation
                if(!confirmation) {
                    confirmation = confirm(Joomla.JText._('COM_APOLL_ARE_YOU_SURE_YOU_WANT_TO_DELETE', 'Are you sure you want to delete this options'));
                }
                
                // if option value is empty or we have true result 
                // from the confirmation preceed with deletion    
                if (confirmation) {    
                    //animate color
                    new Fx.Tween(parent, { 
                        duration:800
                    }).start('background-color', '#FFCFD1', '#fff');
                    
                    //delay the slideOut and disposal
                    (function() {
                        new Fx.Slide(parent, {
                            duration:400, 
                            onComplete: function() {
                            
                                //add the ids of the deleted options to
                                //the value of input#ids_to_delete
                                
                                //what id is to be deleted
                                //get it from the rel atribute of the delete button
                                //var id = (el.get('rel'));
                                
                                //newly created options have not been saved and 
                                //have no id, so they are just disposed
                                //if we are deleting already saved option
                                //we will get its id and add it to the array of
                                //ids to be deleted later
                                if (id) {
                                    var ids_to_delete = $('ids_to_delete');                                      
                                    if (ids_to_delete.value != '') {                      
                                        ids_to_delete.set('value', ids_to_delete.value + ',' + id);
                                    } else {
                                        ids_to_delete.set('value', id);
                                    }
                                }
                                parent.dispose();
                                updateOrdering();                    
                            }
                        }).slideOut();
                    }).delay(300);
                  } else {
                    parent.setStyle('background-color', '#fff');
                  }
                  //keep options in order
                  updateOrdering();
                }
    }
    
    /**
    * method to constantly keep the options ordered
    */
    
    function updateOrdering() 
    {
        $$('.ordering').each(function(o, i){
            o.set('value', i+1);
        });
    }
    
    /**
    * method to add new options
    */
    
    function addOption(where) 
    {
        //count how many labels we already have
        var total_labels = $$('.apoll_option_labels').length;
        
        //inject the new elements
        var newLabel = new Element('label').set({
            'id'    : 'apoll_option_label_' + parseInt(total_labels + 1),
            'for'   : '',
            'class' : 'hasTip apoll_option_labels'
        }).inject(where, 'after'); 
             
        //animate the injection 
         new Fx.Tween(newLabel, { 
            duration:600
        }).start('background-color', '#DFDFDF', '#fff');      

        //TODO find a way to make it work        
/*        //slide it in nicely
        new Fx.Slide(newLabel, {
            duration : 400,
            hideOverflow: false,
            onComplete : function() {
                updateOrdering();
            }
        }).hide().slideIn(); */
        
        new Element('span').set({
            'class': 'handle',
            'text' : total_labels + 1
        }).inject(newLabel);                   
                        
        new Element('input').set({
            'id'   : 'new_poll_option_' + parseInt(total_labels + 1),
            'name' : 'new_poll_option[]',
            'class': 'inputbox poll_options',
            'type' : 'text',
            'title': Joomla.JText._('COM_APOLL_INPUT_OPTION_TEXT', 'Input option text here'),
            'size' : '50',
            events : {
                'keydown' : function(e){
                    if(e.key == 'enter') {
                        addOption(this.getParent());
                    }                    
                }
            }
        }).inject(newLabel);     
            
        // create the colorpicker elements
        // generate random color
        var color = randomColor();
        
        var outer = new Element('span').set({
            'id'   : 'outer' + parseInt( total_labels + 1 ),
            'name' : '',
            'class': 'outer',
            'title': Joomla.JText._('COM_APOLL_PICK_COLOR', 'Pick color'),
            'styles': {
                'background-color' : color
            }
        }).inject(newLabel); 
        
        var colorPicker = new Element('img').set({
            'id'   : 'colorpicker' + parseInt( total_labels + 1 ),
            'class': 'colorpicker',
            'src'  : 'components/com_apoll/assets/apoll-arrow.gif',
            'alt'  : '[r]'
        
        }).inject(outer);   
        
        var new_colorValue = new Element('input').set({
            'id'   : 'new_colorValue' + parseInt( total_labels + 1 ),
            'name' : 'new_colorValue[]',
            'class': 'inputbox',
            'type' : 'hidden',
            'size' : '7',
            'value': color
        }).inject(newLabel); 
        
        // add the color picker behavior to the element
        createColorPicker(colorPicker, i = parseInt( total_labels + 1 ));
                  
        new Element('input').set({
            'id'   : 'delete_me_' + parseInt( total_labels + 1 ),
            'class': 'delete_me hasTip',
            'type' : 'button',
            'title': Joomla.JText._('COM_APOLL_CLICK_TO_DELETE', 'Delete'),
            'rel'  : '',
            'events': {
                'click' : function() { 
                        delete_me(this);
                        }
            }
        }).inject(newLabel);  
        
        new Element('input').set({
            'id'   : 'new_ordering'+parseInt( total_labels + 1 ),
            'name' : 'new_ordering[]',
            'class': 'ordering',
            'type' : 'hidden',
            'size' : '1',
            'value': total_labels + 1
        }).inject(newLabel);         
        
        //add the injected element to the sortables stack
        labels.addItems(newLabel);                   
        updateOrdering();
        // focus on the newly created input
        $('new_poll_option_'+ parseInt( total_labels + 1 )).focus();
        
   }

    // when loading the poll create colorpickers for all options
    $$('.colorpicker').each(function(el, i) 
    {
        createColorPicker(el, i);
    });
    
    /**
    * method to create colorpicker
    */
    function createColorPicker(el, i)
    {

        var parent = el.getParent('span');
        // get the colorValue input
        var next   = parent.getNext('input');
        
        // if we are creating a new poll with empty options
        // generate random colors
        var color = randomColor();
        
        if(next.value == '') 
        {
            next.value = color;
            parent.setStyle('background-color', color);      
        }
        else
        {
            parent.setStyle('background-color', next.value);      
        }
        
        new MooRainbow(el.id, 
        {
            id: 'color'+i,
            wheel: true,
            onChange: function(color) {
                parent.setStyle('background-color', color.hex);
                next.value = color.hex;
            },
            onComplete: function(color) {
                parent.setStyle('background-color', color.hex);
                next.value = color.hex;
            }
        });
    }
    
    /**
    * method to generate random color
    */
    function randomColor() 
    {
         var rint = Math.round(0xffffff * Math.random());
         return ('#0' + rint.toString(16)).replace(/^#0([0-9a-f]{6})$/i, '#$1');
    }

});    
    
    