<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="jQuery Customization of input html file for Bootstrap Twitter">
		<meta name="keywords" content="jquery customization input html file bootstrap twitter">
		<meta name="author" content="markusslima">
		<meta http-equiv="expires" content="Tue, 01 Jan 2013 00:00:00 GMT">
		<meta http-equiv="cache-control" content="public" />
		<meta http-equiv="Pragma" content="public">


        <title>jQuery FileStyle for Bootstrap</title>

		<link rel="icon" type="image/png" href="icons/favicon.png">
        <link href="css/bootstrap.min.css" rel="stylesheet" />

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    </head>

    <body>
        <div class="container" style="margin-top: 30px;margin-bottom: 30px">
            <div class="row">
                <div class="span12">
                	<form class="form-inline" action="upload.php" enctype="multipart/form-data" method="post">
						<div class="control-group">
							<label class="control-label" for="input01">Upload test</label>
							<div class="controls">
								<input type="file" name="example" id="input01">
								<button type="submit" class="btn btn-primary">Enviar</button>
							</div>
						</div>
					</form>
					<form class="form-horizontal well">
						<fieldset>
							<div class="control-group">
								<label class="control-label" for="input00">Default browser</label>
								<div class="controls">
									<input type="file" id="input00">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input02">Custom button text</label>
								<div class="controls">
									<input type="file" id="input02">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input03">No text field</label>
								<div class="controls">
									<input type="file" id="input03">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input04">No icon</label>
								<div class="controls">
									<input type="file" id="input04">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input05">Class bootstrap button</label>
								<div class="controls">
									<input type="file" id="input05">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input06">Class bootstrap input</label>
								<div class="controls">
									<input type="file" id="input06">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input07">Change icon</label>
								<div class="controls">
									<input type="file" id="input07">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input08">Clear button</label>
								<div class="controls">
									<input type="file" id="input08">
									<button id="clear" class="btn" type="button">Clear</button>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input09">Toggle button</label>
								<div class="controls">
									<input type="file" id="input09">
									<button id="toggleInput" class="btn" type="button">Toggle input</button>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input10">Toggle icon</label>
								<div class="controls">
									<input type="file" id="input10">
									<button id="toggleIcon" class="btn" type="button">Toggle icon</button>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="input11">Multiple selection</label>
								<div class="controls">
									<input type="file" multiple="multiple" id="input11">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="input12">Remove text button</label>
								<div class="controls">
									<input type="file" id="input12">
								</div>
							</div>
						</fieldset>
					</form>
					<form class="form-horizontal well">
						<div class="control-group">
							<div class="controls">
								<input type="file" class="test">
            		    	</div>
            		    </div>
						<div class="control-group">
							<div class="controls">
								<input type="file" class="test">
            		    	</div>
                		</div>
						<div class="control-group">
							<div class="controls">
								<input type="file" class="test">
            		    	</div>
		                </div>
						<div class="control-group">
							<div class="controls">
								<input type="file" class="test">
            		    	</div>
        		        </div>
					</form>

					<form class="form-horizontal well">
						<div class="control-group">
							<div class="controls">
								<input type="file" class="filestyle" data-icon="false">
            		    	</div>
            		    </div>
						<div class="control-group">
							<div class="controls">
								<input type="file" class="filestyle" data-buttonText="Find">
            		    	</div>
                		</div>
						<div class="control-group">
							<div class="controls">
								<input type="file" class="filestyle" data-classInput="input-xxlarge">
            		    	</div>
		                </div>
						<div class="control-group">
							<div class="controls">
								<input type="file" class="filestyle" data-buttonText="Open" data-input="false" data-classIcon="icon-plus" data-classButton="btn btn-primary">
            		    	</div>
        		        </div>
					</form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../src/bootstrap-filestyle.js"></script>
        <script type="text/javascript" src="js/aplication.js"></script>
    </body>
</html>