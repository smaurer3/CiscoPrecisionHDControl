
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>PTZ Control</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-icons.css">

	<style>
		#direction-pad {
			display: grid;
			grid-template-columns: 1fr 1fr 1fr;
			grid-template-rows: 1fr 1fr 1fr;
			gap: 10px;
			padding: 10px;
			background-color: #f5f5f5;
			border: 1px solid #ddd;
			border-radius: 5px;
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.2);
			margin-bottom: 20px;
			touch-action: none;
		}

		.direction-button {
			grid-column: 2 / 3;
			grid-row: 2 / 3;
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 50%;
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.2);
			cursor: pointer;
			height: 100%;
			outline: none;
			transition: background-color 0.1s ease-in-out, box-shadow 0.1s ease-in-out;
			width: 100%;
		}

		.direction-button:hover {
			background-color: #f5f5f5;
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.4);
		}

		.direction-button.active {
			background-color: #f5f5f5;
			box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.4);
		}

		.direction-button.up {
			grid-row: 1 / 2;
		}

		.direction-button.down {
			grid-row: 3 / 4;
		}

		.direction-button.left {
			grid-column: 1 / 2;
		}

		.direction-button.right {
			grid-column: 3 / 4;
		}

		.direction-button.up-left {
			grid-row: 1 / 2;
			grid-column: 1 / 2;
		}

		.direction-button.up-right {
			grid-row: 1 / 2;
			grid-column: 3 / 4;
		}

		.direction-button.down-left {
			grid-row: 3 / 4;
			grid-column: 1 / 2;
		}

		.direction-button.down-right {
			grid-row: 3 / 4;
			grid-column: 3 / 4;
		}

</style>
</head>
<body>
	<div class="container">
		<div class="row m-3">
			<h1>Cisco PTZ Control</h1>
		</div>
		<div class="row">
			<div class="col-8 col-lg-4">
				<div id="direction-pad">
					
					<button class="direction-button up" data-direction="pan_tilt_up" data-action="ptz"><span class="bi bi-arrow-up"></span></button>
					<button class="direction-button up-left" data-direction="pan_tilt_up_left" data-action="ptz"><span class="bi bi-arrow-up-left"></span></button>
					<button class="direction-button left" data-direction="pan_tilt_left" data-action="ptz"><span class="bi bi-arrow-left"></span></button>
					<button class="direction-button down-left" data-direction="pan_tilt_down_left" data-action="ptz"><span class="bi bi-arrow-down-left"></span></button>
					<button class="direction-button right" data-direction="pan_tilt_right" data-action="ptz"><span class="bi bi-arrow-right"></span></button>
					<button class="direction-button up-right" data-direction="pan_tilt_up_right" data-action="ptz"><span class="bi bi-arrow-up-right"></span></button>
					<button class="direction-button down" data-direction="pan_tilt_down" data-action="ptz"><span class="bi bi-arrow-down"></span></button>
					<button class="direction-button down-right" data-direction="pan_tilt_down_right" data-action="ptz"><span class="bi bi-arrow-down-right"></span></button>
					<button class="direction-button preset-button " data-direction="HOME" data-action="recall_preset"><span class="bi bi-house"></span></button>
				</div>
			</div>
			<div class="col-4">
				<button class="btn btn-info m-1 zoom-button " data-direction="zoom_tele" data-action="lens">Zoom In</button>
				<button class="btn btn-info m-1 zoom-button " data-direction="zoom_wide" data-action="lens">Zoom Out</button>
		</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<button class="btn btn-danger  m-1 preset-button " data-direction="1" data-action="set_preset">Set Preset 1</button>
				<button class="btn btn-success m-1 preset-button " data-direction="1" data-action="recall_preset">Recall Preset 1</button>
			</div>
		</div>
				<div class="row">
			<div class="col-lg-4">
				<button class="btn btn-danger m-1  preset-button " data-direction="2" data-action="set_preset">Set Preset 2</button>
				<button class="btn btn-success m-1 preset-button " data-direction="2" data-action="recall_preset">Recall Preset 2</button>
			</div>
		</div>
				<div class="row">
			<div class="col-lg-4">
				<button class="btn btn-danger  m-1 preset-button " data-direction="3" data-action="set_preset">Set Preset 3</button>
				<button class="btn btn-success m-1 preset-button " data-direction="3" data-action="recall_preset">Recall Preset 3</button>
			</div>
		</div>
			<div class="row">
			<div class="col-lg-4">
				<button class="btn btn-danger  m-1 preset-button " data-direction="4" data-action="set_preset">Set Preset 4</button>
				<button class="btn btn-success m-1 preset-button " data-direction="4" data-action="recall_preset">Recall Preset 4</button>
			</div>
		</div>
		
		</div>
	</div>




	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script>

	var connectionUrl = 'ws://<?= $_SERVER['SERVER_ADDR']; ?>:8765';
    var connection;
    var isConnected = false;
    var retryCount = 0;
    var retryMax = 100;

    function connect() {
        if (retryCount < retryMax) {
            console.log('WebSocket connecting...');
            connection = new WebSocket(connectionUrl);
            retryCount++;
            connection.onopen = function(event) {
                console.log('WebSocket connected');
                isConnected = true;
                retryCount = 0;
            };
            connection.onmessage = function(event) {
                console.log('WebSocket message:', event.data);
            };
            connection.onerror = function(event) {
                console.error('WebSocket error:', event);
                isConnected = false;
                setTimeout(connect, 1000);
            };
            connection.onclose = function(event) {
                console.warn('WebSocket closed:', event);
                isConnected = false;
                setTimeout(connect, 1000);
            };
        } else {
            console.error('WebSocket connection failed after', retryCount, 'attempts');
        }
    }

    connect();

    $('.direction-button, .preset-button, .zoom-button').on('mousedown touchstart', function() {
        $(this).addClass('active');
        if (isConnected) {
            var message = {
                'action': $(this).data('action'),
                'message': $(this).data('direction')
            };
            connection.send(JSON.stringify(message));
        } else {
            console.warn('WebSocket is not connected');
        }
    });

    $('.direction-button').on('mouseup touchend', function() {
        $(this).removeClass('active');
        if (isConnected) {
            var message = {
                'action': 'ptz',
                'message': 'pan_tilt_stop'
            };
            connection.send(JSON.stringify(message));
        } else {
            console.warn('WebSocket is not connected');
        }
    });

    $('.zoom-button').on('mouseup touchend', function() {
        $(this).removeClass('active');
        if (isConnected) {
            var message = {
                'action': 'lens',
                'message': 'zoom_stop'
            };
            connection.send(JSON.stringify(message));
        } else {
            console.warn('WebSocket is not connected');
		}

	});

	</script>
</body>
</html>
