<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'openalpr');
$eqLogics = eqLogic::byType('openalpr');
?>

<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default btn-sm tooltips snapshot" title="Snapshot"><i class="fa fa-camera"></i> {{}}</a>
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un groupe}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
                foreach ($eqLogics as $eqLogic) {
                    echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
	<div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
		<legend>{{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor snapshot" style="background-color : #ffffff;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
			  <center>
				<i class="fa fa-camera" style="font-size : 5em;color:#767676;"></i>
			  </center>
				<center>{{Snapshot}}</center>
			</div>
			<div class="cursor logAlprd" style="background-color : #ffffff;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
			  <center>
				<i class="fa fa-file-o" style="font-size : 5em;color:#767676;"></i>
			  </center>
				<center>{{Log ALPRD}}</center>
			</div>
		</div>
        <legend>{{Mes groupes de plaques d'immatriculation}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; " >
				<center>
					<i class="fa fa-plus-circle" style="font-size : 7em;color:#497CB1;"></i>
				</center>
				<span style="font-size : 1.1em;position:relative; word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#497CB1">
					<center>Ajouter</center>
				</span>
			</div>
			<?php
			if (count($eqLogics) == 0) {
				echo "<br/><br/><br/><center><span style='color:#767676;font-size:1.2em;font-weight: bold;'>{{Vous n'avez pas encore de groupe de plaque d'immatriculation, cliquez sur Ajouter un groupe pour commencer}}</span></center>";
			} else {
			?>
				<?php
				foreach ($eqLogics as $eqLogic) {
					echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
					echo "<center>";
					echo '<img src="plugins/openalpr/doc/images/openalpr_icon.png" height="105" width="95" />';
					echo "</center>";
					echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
					echo '</div>';
				}
				?>
			<?php } ?>
		</div>
    </div>
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
        <form class="form-horizontal">
            <fieldset>
				<legend><i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}  <i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i></legend>
				<div class="form-horizontal">
					<div class="form-group">
						<label class="col-md-2 control-label">{{Nom du groupe}}</label>
						<div class="col-sm-3">
							<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
							<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom du groupe}}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" >{{Objet parent}}</label>
						<div class="col-sm-3">
							<select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
								<option value="">{{Aucun}}</option>
								<?php
								foreach (object::all() as $object) {
									echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
								}
								?>
							</select>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 control-label" ></label>
						<div class="col-sm-9">
							<input type="checkbox" class="eqLogicAttr bootstrapSwitch" data-label-text="{{Activer}}" data-l1key="isEnable" checked/>
							<input type="checkbox" class="eqLogicAttr bootstrapSwitch" data-label-text="{{Visible}}" data-l1key="isVisible" checked/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">{{Catégorie}}</label>
						<div class="col-md-8">
							<?php
							foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
								echo '<label class="checkbox-inline">';
								echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
								echo '</label>';
							}
							?>

						</div>
					</div>
				</div>
			</fieldset> 
        </form>
        <legend>{{Liste des plaques appartenant a ce groupe}}</legend>
        <a class="btn btn-success btn-sm cmdAction" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un plaque d'immatriculation}}</a><br/><br/-->
        <table id="table_cmd" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>{{Nom}}</th>
					<th>{{Numero de la plaque}}</th>
					<th>{{Action}}</th>
                    <th>{{}}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <form class="form-horizontal">
            <fieldset>
                <div class="form-actions">
                    <a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
                    <a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
                </div>
            </fieldset>
        </form>

    </div>
</div>

<?php include_file('desktop', 'openalpr', 'js', 'openalpr'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>