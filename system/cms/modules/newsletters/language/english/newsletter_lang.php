<?php

// labels
$lang['newsletters.subject'] 						= 'Subject';
$lang['newsletters.created'] 						= 'Created';
$lang['newsletters.sent'] 							= 'Sent On';
$lang['newsletters.actions'] 						= 'Actions';
$lang['newsletters.not_sent_label'] 				= 'Not sent';
$lang['newsletters.view'] 							= 'View';
$lang['newsletters.edit'] 							= 'Edit';
$lang['newsletters.delete'] 						= 'Delete';
$lang['newsletters.send'] 							= 'Send All';
$lang['newsletters.send_cron'] 						= 'Send Cron';
$lang['newsletters.send_batch']						= 'Send Batch';
$lang['newsletters.pending']						= 'Pending Cron';
$lang['newsletters.export_xml'] 					= 'Export XML';
$lang['newsletters.export_csv'] 					= 'Export CSV';
$lang['newsletters.export_json'] 					= 'Export JSON';
$lang['newsletters.title_label'] 					= 'Newsletter Subject';
$lang['newsletters.email_label'] 					= 'Email Address';
$lang['newsletters.subscribe'] 						= 'Subscribe';
$lang['newsletters.unsubscribe'] 					= 'Unsubscribe';
$lang['newsletters.subject_suffix'] 				= 'Newsletter';
$lang['newsletters.target']							= 'Target URL';
$lang['newsletters.url']							= 'Insert URL';
$lang['newsletters.add']							= 'Add Another URL';
$lang['newsletters.stats']							= 'Statistics';
$lang['newsletters.unique_opens']					= 'Unique Opens';
$lang['newsletters.total_opens']					= 'Total Opens';
$lang['newsletters.template_select']				= 'Select Template';
$lang['newsletters.template_title']					= 'Template Title';
$lang['newsletters.template_select_edit']			= 'Select Template To Edit';
$lang['newsletters.template_edit']					= 'Edit Template';
$lang['newsletters.template_new']					= 'Create A New Template';
$lang['newsletters.tracked_urls']					= 'Tracked URLs';
$lang['newsletters.body']							= 'Newsletter Body';
$lang['newsletters.template_body']					= 'Template Body';

// titles
$lang['newsletters.letter_title']					= 'Newsletter';
$lang['newsletters.newsletters']					= 'Newsletters';
$lang['newsletters.add_title']						= 'Create newsletter';
$lang['newsletters.edit_title']						= 'Edit newsletter';
$lang['newsletters.list_title'] 					= 'List newsletters';
$lang['newsletters.title_newsletter_opens']			= 'Track Newsletter Opens';
$lang['newsletters.title_newsletter_urls']			= 'Add Tracked URL';
$lang['newsletters.click_report']					= 'Click Report';
$lang['newsletters.open_statistics']				= 'Open Statistics';
$lang['newsletters.templates']						= 'Templates';
$lang['newsletters.template_manager']				= 'Template Manager';
$lang['newsletters.subscribers']					= 'Subscribers';
$lang['newsletters.statistics']						= 'Statistics';

// messages
$lang['newsletters.example_email']					= 'user@example.com';
$lang['newsletters.no_newsletters_error'] 			= 'There are no newsletters. <a href="'.current_url().'/create">Create one</a>';
$lang['newsletters.subscribed_success'] 			= 'You have now subscribed. You should hear from us when we send out the next newsletter.';
$lang['newsletters.admin_subscribed_success'] 		= 'The email has been added to your subscriber list. They will receive the next newsletter.';
$lang['newsletters.subscribe_desc'] 				= 'Subscribe to our newsletter to receive emails and useful news articles.';
$lang['newsletters.subscriber_count']				= 'You have %s subscribers.';
$lang['newsletters.unsubscribe_success'] 			= 'The email has been removed from your list.';
$lang['newsletters.unsubscribe_error'] 				= 'Sorry the email could not be removed.';
$lang['newsletters.duplicate_email'] 				= 'This address has already been registered.';
$lang['newsletters.default_email'] 					= 'Please provide an email address.';
$lang['newsletters.delete_mail_success'] 			= 'You have been removed from the newsletter mailing list.';
$lang['newsletters.delete_mail_error'] 				= 'Your email address could not be deleted from our list. Please contact us and we will remove it manually.';
$lang['newsletters.add_success'] 					= 'The newsletter "%s" was saved.';
$lang['newsletters.add_error'] 						= 'An error occured and the newsletter was not saved.';
$lang['newsletters.template_add_success'] 			= 'The template "%s" was saved successfully.';
$lang['newsletters.template_delete_success'] 		= 'The template was deleted successfully.';
$lang['newsletters.sent_success'] 					= 'The newsletter was sent successfully.';
$lang['newsletters.sent_error'] 					= 'An error occured and the newsletter was not sent to all subscribers. Check your settings and resend. Emails that were successful will not be resent.';
$lang['newsletters.no_subscribers']					= 'The newsletter has already been sent to all current subscribers or you have no subscribers.';
$lang['newsletters.all_sent']						= 'All %s emails have been sent';
$lang['newsletters.number_sent']					= '%s of %s emails have been sent';
$lang['newsletters.confirm']						= 'You are about to launch an email campaign. Are you sure?';
$lang['newsletters.tracked_urls_error']				= 'There is an invalid value in a tracked url field. All addresses must begin with http:// or https://';
$lang['newsletters.sending']						= 'Sending...';
$lang['newsletters.cron_set']						= 'Newsletters will be sent when the Cron job runs.';
$lang['newsletters.opt_in_message']					= 'Thank you. An activation email has been sent to the address provided. You must click the link within that email before you will be added to our list.';
$lang['newsletters.opt_in_success']					= 'Congratulations! Your email has been added to our list and you will begin receiving newsletters soon.';
$lang['newsletters.opt_in_error']					= 'Sorry. It appears that your activation link is invalid or your email has been removed. Please resubscribe or contact us.';