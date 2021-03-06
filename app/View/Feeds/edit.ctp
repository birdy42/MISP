<div class="feed form">
<?php echo $this->Form->create('Feed');?>
	<fieldset>
		<legend>Edit MISP Feed</legend>
		<p>Edit a new MISP feed source.</p>
	<?php
			echo $this->Form->input('enabled', array());
			echo $this->Form->input('name', array(
					'div' => 'input clear',
					'placeholder' => 'Feed name',
					'class' => 'form-control span6',
			));
			echo $this->Form->input('provider', array(
					'div' => 'input clear',
					'placeholder' => 'Name of the content provider',
					'class' => 'form-control span6'
			));
			echo $this->Form->input('url', array(
					'div' => 'input clear',
					'placeholder' => 'URL of the feed',
					'class' => 'form-control span6'
			));
			echo $this->Form->input('source_format', array(
					'label' => 'Source Format',
					'div' => 'input clear',
					'options' => $feed_types,
					'class' => 'form-control span6'
			));
		?>
		<div id="TargetDiv" class="optionalField">
		<?php 
			echo $this->Form->input('fixed_event', array(
					'label' => 'Target Event',
					'div' => 'input clear',
					'options' => array('New Event Each Pull', 'Fixed Event'),
					'class' => 'form-control span6'
			));
		?>
		</div>
		<div id="TargetEventDiv" class="optionalField">
		<?php
			echo $this->Form->input('target_event', array(
					'label' => 'Target Event ID',
					'div' => 'input clear',
					'placeholder' => 'Leave blank unless you want to reuse an existing event.',
					'class' => 'form-control span6'
			));
		?>
		</div>
		<div id="settingsCsvValueDiv" class="optionalField">
			<?php
				echo $this->Form->input('Feed.settings.csv.value', array(
						'label' => 'Value field(s) in the CSV',
						'title' => 'Select one or several fields that should be parsed by the CSV parser and converted into MISP attributes',
						'div' => 'input clear',
						'placeholder' => '2,3,4 (column position separated by commas)',
						'class' => 'form-control span6'
				));
			?>
		</div>
		<div id="PublishDiv" class="input clear optionalField">
		<?php
			echo $this->Form->input('publish', array(
					'label' => 'Auto Publish',
					'type' => 'checkbox',
					'class' => 'form-control'
			));
		?>
		</div>
		<div id="OverrideIdsDiv" class="input clear optionalField">
		<?php
			echo $this->Form->input('override_ids', array(
					'label' => 'Override IDS Flag',
					'title' => 'If checked, the IDS flags will always be set to off when pulling from this feed',
					'type' => 'checkbox',
					'class' => 'form-control'
			));
		?>
		</div>
		<div id="DeltaMergeDiv" class="input clear optionalField">
		<?php
			echo $this->Form->input('delta_merge', array(
					'label' => 'Delta Merge',
					'title' => 'Merge attributes (only add new attributes, remove revoked attributes)',
					'type' => 'checkbox',
					'class' => 'form-control'
			));
		?>
		</div>
		<?php 
			echo $this->Form->input('distribution', array(
					'options' => array($distributionLevels),
					'div' => 'input clear',
					'label' => 'Distribution',
			));
		?>
		<div id="SGContainer" style="display:none;">
		<?php
			if (!empty($sharingGroups)) {
				echo $this->Form->input('sharing_group_id', array(
						'options' => array($sharingGroups),
						'label' => 'Sharing Group',
				));
			}
		?>
		</div>
		<div class="input clear"></div>
		<?php
			echo $this->Form->input('tag_id', array(
					'options' => $tags,
					'label' => 'Default Tag',
			));
		echo $this->Form->input('pull_rules', array('style' => 'display:none;', 'label' => false, 'div' => false));
	?>
	</fieldset>
    <b>Filter rules:</b><br />
    <span id="pull_tags_OR" style="display:none;">Events with the following tags allowed: <span id="pull_tags_OR_text" style="color:green;"></span><br /></span>
    <span id="pull_tags_NOT" style="display:none;">Events with the following tags blocked: <span id="pull_tags_NOT_text" style="color:red;"></span><br /></span>
    <span id="pull_orgs_OR" style="display:none;">Events with the following organisations allowed: <span id="pull_orgs_OR_text" style="color:green;"></span><br /></span>
    <span id="pull_orgs_NOT" style="display:none;">Events with the following organisations blocked: <span id="pull_orgs_NOT_text" style="color:red;"></span><br /></span>
	<span id="pull_modify"  class="btn btn-inverse" style="line-height:10px; padding: 4px 4px;">Modify</span><br /><br />
	<?php
	echo $this->Form->button('Edit', array('class' => 'btn btn-primary'));
	echo $this->Form->end();
	?>
	<div id="hiddenRuleForms">
		<?php echo $this->element('serverRuleElements/pull'); ?>
	</div>
</div>
<?php
	echo $this->element('side_menu', array('menuList' => 'feeds', 'menuItem' => 'edit'));
?>
<script type="text/javascript">
//
var formInfoValues = {
		'ServerUrl' : "The base-url to the external server you want to sync with. Example: https://foo.sig.mil.be",
		'ServerName' : "A name that will make it clear to your users what this instance is. For example: Organisation A's instance",
		'ServerOrganization' : "The organization having the external server you want to sync with. Example: BE",
		'ServerAuthkey' : "You can find the authentication key on your profile on the external server.",
		'ServerPush' : "Allow the upload of events and their attributes.",
		'ServerPull' : "Allow the download of events and their attributes from the server.",
		'ServerSubmittedCert' : "You can also upload a certificate file if the instance you are trying to connect to has its own signing authority.",
		'ServerSelfSigned' : "Click this, if you would like to allow a connection despite the other instance using a self-signed certificate (not recommended)."
};


var rules = {"pull": {"tags": {"OR":[], "NOT":[]}, "orgs": {"OR":[], "NOT":[]}}};
var validOptions = ['pull'];
var validFields = ['tags', 'orgs'];
var modelContext = 'Feed';

$(document).ready(function() {
	rules = convertServerFilterRules(rules);
	feedDistributionChange();
	$("#pull_modify").click(function() {
		serverRuleFormActivate('pull');
	});
	$("#FeedDistribution").change(function() {
		feedDistributionChange();
	});
	feedFormUpdate();
});

$("#FeedSourceFormat, #FeedFixedEvent").change(function() {
	feedFormUpdate();
});
</script>
