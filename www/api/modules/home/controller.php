<script class='controller'>
setTimeout(function() {
	var startDate = new Date("2019-11-11");

	var today = new Date(), dd = today.getDate() + 1, mm = today.getMonth() + 1, yyyy = today.getFullYear();
	if (dd < 10) { dd = '0' + dd; } 
	if (mm < 10) { mm = '0' + mm; } 
	today = yyyy + '-' + mm + '-' + dd, endDate = new Date(today);

	var getDateArray = function(start, end) {
		var arr = new Array();
		var dt = new Date(start);
		while (dt <= end) {
			var thisday = new Date(dt), d = thisday.getDate() + 1, m = thisday.getMonth() + 1, y = thisday.getFullYear();
			if (d < 10) { d = '0' + d; } 
			if (m < 10) { m = '0' + m; } 
			thisday = y + '-' + m + '-' + d;
			arr.push(thisday);
			dt.setDate(dt.getDate() + 1);
		}
		return arr;
	}

	var dateArr = getDateArray(startDate, endDate);
	dateArr.splice(-1,1);
	for (var i = 0; i < dateArr.length; i++) {
		// console.log("<p>" + dateArr[i] + "</p>");
	}

    var chartdata = [{
            name: 'Prov', type: 'line', smooth: true,
            data: [12, 25, 10, 30, 10, 25, 36, 14, 25],
            lineStyle: { normal: { width: 1 } }, symbolSize: 10,
            lineStyle: { normal: { width: 3 } },
        },
        {
            name: 'Cli', type: 'bar', smooth: true,
            data: [15, 20, 5, 8, 18, 25, 12, 12, 18],
            lineStyle: { normal: {} },
            itemStyle: { normal: { 
				width: 1, 
				barBorderRadius: [3, 3, 0, 0],
            	color: new echarts.graphic.LinearGradient(
					0, 0, 0, 1,  [{ offset: 0, color: '#4d83ff' }, { offset: 1, color: '#4d83ff' } ] 
				) }
            },
        }
    ];
    var chart = document.getElementById('activacioChart');
    var barChart = echarts.init(chart);
    var option = {
        grid: { top: '6', right: '0', bottom: '17', left: '25', },
        xAxis: {
            data: ['11-11', '11-12', '11-13', '11-14', '11-15', '11-16', '11-17', '11-18', '11-19'],
            axisLine: { lineStyle: { color: 'rgba(167, 180, 201,.1)' } },
            axisLabel: { fontSize: 10, color: '#a7b4c9' }
        },
        tooltip: {
            show: true,
            showContent: true,
            alwaysShowContent: true,
            triggerOn: 'mousemove',
            trigger: 'axis',
            axisPointer: { label: { show: false, } }
        },
        yAxis: {
            splitLine: { lineStyle: { color: 'rgba(167, 180, 201,.1)' } },
            axisLine: { lineStyle: { color: 'rgba(167, 180, 201,.1)' } },
            axisLabel: { fontSize: 10, color: '#a7b4c9' }
        },
        series: chartdata,
        color: ['#ffc94d', '#4d83ff']
    };
    barChart.setOption(option);

    var formData = new FormData();
    formData.append('meth', 'feedHome');
    /* $.ajax({
    	url: apiURI, type: 'POST', dataType: "json", cache: false, contentType: false, processData: false, data: formData,
    	success: function (data) {
    		if (data.scriptResp == "done") {
    			$('#newClis').html('59');
    			$('#newProv').html('40');
    			$('#allped').html('4');
    		} else {
    			console.log('hubo un error #3343234');
    		}
    	},
    	error: function (error) {
    		$('body').append('<center>revise su conexion</center>');
    		console.log("Hubo un error de internet, intente de nuevo");
    		console.log(error);
    	}
    }); */

    $('#newClis').html('59');
    $('#newProv').html('40');
    $('#allped').html('4');

    /** wake Counters */
    $('.count').countUp();
}, 1000);
</script>