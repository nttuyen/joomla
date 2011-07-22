/**
 * aPoll Voting Component
 *
 * @version     $Id: mod_apoll.js 157 2011-02-20 20:36:00Z harrygg $
 * @package     Joomla
 * @copyright   Copyright (C) 2009 - 2010 aFactory. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */

var apollVoteClass = new Class ({

	options: {
            poll_id : 0,
            debug : 1
	},
	Implements: [Options,Events],
	initialize: function(container, options) {

		this.setOptions(options);
		//settings
		this.container = document.id(container);
		this.poll_id = (this.options.poll_id) ? this.options.poll_id : this.container.id.substr(10);
                this.form = document.id('apoll_form_' + this.poll_id);
                //DEBUG
                //(this.options.debug)? console.log('aPoll Container Id: '+this.container.id+ '\naPoll Form Id: '+this.form.id+'\nPoll Id: '+this.poll_id) : '';

		// initialize options and add events to the form if the form exists
		if(this.form) {
			// get the poll options
			this.formOptions = this.container.getElements('input[type="radio"]');
			this.submitBtn = this.container.getElement('input[type="submit"]');
			this.loadingDiv = this.container.getElement('div[id^="apoll_loading"]');
			this.showTotal = this.container.getElement('input[name="show_total"]').value;

                        this.submitBtn.addEvent('click', function(e){
                            if(e) e.stop();
                            if(this.checkSelected()){
                                this.submitForm();
                            }
                        }.bind(this));

		// if the form doesn't exist we are showing the results
		} else {
			this.apollRefreshBtn = document.id('apoll_refresh_btn_' + this.poll_id);
			this.apollRefreshBtn.addEvent('click', function(e){
				if(e) e.stop();
				this.refreshBtnRequest();
        }.bind(this));

		}
    },
	// METHODS
	// function to check if we have selected an options
	checkSelected : function() {
		var noSelection = true;
		this.formOptions.each(function (e){
            // check if there is a selected option
            if(e.checked == 1) {
					noSelection = false;
				}
        });
		// if no option is selected raise an alert
		if (noSelection) {
			alert(Joomla.JText._('MOD_APOLL_PLEASE_SELECT_AN_OPTION','Please select an option'));
			return false;
		}
		return true;
	},

	// function to send the request
	submitForm : function() {
		// disable the submit button
		this.submitBtn.disabled = true;
		// add the loading img
		this.loadingDiv.setStyle('display','');
                // set the request
		this.form.set('send', {
			//onFailure: function() {console.log('Failure');},
			//onComplete: function() {console.log('Setting the form completed')},
			onSuccess: function(response) {
				//DEBUG
				//console.log('Success');
				// parse the txt response to convert it to JSON
				this.responseJSON = JSON.parse(response);
				// draw the XHTML
				this.drawResults();
				//update the results
				this.updateResults();
			}.bind(this)
		}).send();
	},

	// function to draw the bars on the page
	drawResults : function(responseJSON) {

		this.loadingDiv.setStyle('display','none');
		// prepare the results
		var _html = new Element('div');
		var options = this.responseJSON.options;

		options.each( function(e, i){
			var inner = new Element('div');
			new Element('div.apoll_options_text_div').inject(inner);
			var apoll_options_container = new Element ('div.apoll_options_container').inject(inner);
			// create the bar and inject it into the container
			new Element('div.apoll_bars').inject(apoll_options_container);

			inner.inject(_html);
		});

		// empty the container and inject the results
		_html.inject(this.container.empty());


		// create the total votes text and add it to the DOM if allowed
		if(this.showTotal != 0) {
			new Element('br').inject(this.container);
			new Element('b', {html: Joomla.JText._('MOD_APOLL_TOTAL_VOTES', 'Total votes')}).inject(this.container);
			new Element('span#apoll_total_votes',{html:this.responseJSON.total_votes}).inject(this.container);
		}

		// create the refresh button and inject it
		this.createRefreshBtn();

	},

	// method to update the results
	updateResults : function() {

		var options = this.responseJSON.options;
		var options_text = this.container.getElements('div.apoll_options_text_div');
		var options_bars = this.container.getElements('div.apoll_bars');

		options.each( function(e, i) {
			var percent = this.calcPercent(e.votes, this.responseJSON.total_votes);
			var width   = percent ? parseInt(percent) + '%' : '2px';

			options_text[i].empty().set('html', e.text + ' - ' + percent  + '%');
			options_bars[i].setStyle('width', width).setStyle('background-color', e.color);
		}.bind(this));

		//update the total votes if they exists
		var total = this.container.getElement('span');
		if(total) {total.set('html', this.responseJSON.total_votes);}

		// check for errors and show them. If we are not allowed to show errors there will be no errors at all.
		if(this.responseJSON.error) {
			new Element('span.apoll_error_msg', {html: Joomla.JText._(this.responseJSON.error)}).inject(this.container);
		}

	},

	// method to calculate the percentage for given votesh returns float 00.00
	calcPercent : function(votes, totalVotes) {
	    var percent = Math.round(parseFloat(votes*100/totalVotes)*10)/10;
		return percent;
	},

	// method to create a refresh-results-button
	createRefreshBtn : function() {
		//create the refresh button and prepare its logic
		this.apollRefreshBtn = new Element('a.apoll_refresh_btn', {
			id     : 'apoll_refresh_btn_' + this.poll_id,
			href   : '',
			html   : Joomla.JText._('MOD_APOLL_REFRESH_RESULTS', 'Refresh results'),
			events : {
                            click : function(e){
                                if(e) e.stop();
                                //make the ajax call
                                this.refreshBtnRequest();
                            }.bind(this)
			}
		}).inject(this.container);
	},

	// Method to create Request for the refresh button
	refreshBtnRequest : function() {
		//make the ajax call
		new Request.JSON({
                    data: {'option':'com_apoll', 'poll_id' : this.poll_id, 'apoll_option' : 0, 'view' : 'poll', 'format':'json'},
                    onRequest: function() {
                            // we need to find the created refresh button
                            document.id('apoll_refresh_btn_' + this.poll_id).addClass('apoll_loading_img');
                    }.bind(this),
                    onSuccess: function(responseJSON) {
                            // update the results
                            this.responseJSON = responseJSON;
                            document.id('apoll_refresh_btn_' + this.poll_id).removeClass('apoll_loading_img');
                            //update the results
                            this.updateResults();
                    }.bind(this)
		}).send();
	}
});


