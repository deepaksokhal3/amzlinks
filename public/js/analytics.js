	//functions
	function query(params) {
		return new Promise(function(resolve, reject) {
			var data = new gapi.analytics.report.Data({query: params});
			data.once('success', function(response) { resolve(response); })
			.once('error', function(response) { reject(response); })
			.execute();
		});
	}