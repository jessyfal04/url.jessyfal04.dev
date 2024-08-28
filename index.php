<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>URL Redirection</title>

	<link rel="stylesheet" href="res/bulma.min.css">
	<link rel="stylesheet" href="res/style.css">
	<script src="res/jquery-3.7.1.min.js"></script>
	<script src="res/script.js"></script>

	<link rel="icon" type="image/png" href="res/forwarding.png">
</head>
<body>
		<!-- hero  -->
	<section class="hero is-info">
		<div class="hero-body">
			<h1 class="title">URL Redirection</h1>
			<h2 class="subtitle">Allow everyone to redirect a URL to another one</h2>
		</div>
	</section>

	<div id="messages" style="position:sticky; top:0px; z-index:10;"></div>

	<section class="section">

		<div class="box">
			<h4 class="title is-4">Redirection code</h4>

			<div class="field">
				<label class="label">Code</label>
				<div class="field has-addons">
					<p class="control">
						<a class="button is-static">
							url.jessyfal04.dev/
						</a>
					</p>
					<div class="control">
						<input type="text" id="code" class="input" placeholder="test" oninput="codeChanged()">
					</div>
				</div>
			</div>

			<div class="field">
				<div class="control">
					<button class="button is-info" onclick="verifCode();" id="verify-button">Verify</button>
				</div>
			</div>

			<hr>

			<h4 class="title is-4 if-exists">Informations</h4>

			<div class="field">
				<p class="is-text if-exists">Number of visits : <b><span id="nbVisites">?</span></b></p>
				<p class="is-text if-exists">Destination : <b><span id="redirectionUrl">?</span></b></p>
			</div>


			<h4 class="title is-4 if-no-exists">Create a redirection</h4>
			<h4 class="title is-4 if-exists">Delete this redirection</h4>

			<div class="field if-no-exists">
				<label class="label">URL to redirect</label>
				<div class="control">
					<input type="text" id="url" class="input" placeholder="google.com">
				</div>
			</div>

			<div class="field if-no-exists if-exists">
				<label class="label">Passphrase for management</label>
				<div class="control">
					<input type="text" id="passphrase" class="input" placeholder="1234" type="passphrase">
				</div>
			</div>

			
			<div class="field if-no-exists">
				<div class="control">
					<button class="button is-primary" onclick="createRedirection();">Create</button>
				</div>
			</div>


			<div class="field if-exists">
				<div class="control">
					<button class="button is-danger" onclick="deleteRedirection();">Delete</button>
				</div>
			</div>
		</div>
	</section>

	<footer class="footer">
		<a href="https://www.flaticon.com/free-icons/redirect" title="redirect icons">Redirect icons created by Eucalyp - Flaticon</a>
	</footer>
</body>
</html>