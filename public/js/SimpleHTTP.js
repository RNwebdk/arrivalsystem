export default class SimpleHTTP{
    constructor(){
    	// console.log("SimpleHTTP was loaded");
        this.http = new XMLHttpRequest();
    }

    get(url, callback, loadElement = null){
		this.http.open('GET', url, true);
    	this.http.onprogress = function(){
			if (loadElement) {
				document.querySelector(".loadarea").style.height = '0';
          		document.getElementById(loadElement).innerHTML = '';
		   		// document.getElementById(loadElement).innerHTML = '<img src="../img/loading.gif" />'; // Set here the image before sending request
			}
		}

		this.http.onload = () => {
			if (this.http.status === 200) {
				callback(null, JSON.parse(this.http.responseText));
			}else{
				callback('Error: ' + this.http.status);
			}
		}

		this.http.send();
    }

    post(url, data, callback){

		this.http.onload = () => {
			callback(null, JSON.parse(this.http.responseText));
		}

    	this.http.open('POST', url, true);
		// this header is needed to send data in the post request
		// this.http.setRequestHeader('Content-type', 'application/json; charset=utf-8');
		this.http.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=utf-8");
		// this.http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		this.http.send(data);
    }

    put(url, data, callback){


		this.http.onload = () => {
			callback(null, this.http.responseText);
		}

    	this.http.open('POST', url, true);
		// this header is needed to send data in the put request
		// this.http.setRequestHeader('Content-type', 'application/json; charset=utf-8');
		this.http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=utf-8');
		// this.http.send(JSON.stringify(data));
		this.http.send(data);

    }

    delete(url, callback){
    	this.http.open('DELETE', url, true);

		this.http.onload = () => {
			if (this.http.status === 200) {
				callback(null, 'Post Deleted');
			}else{
				callback('Error: ' + this.http.status)
			}
		}

		this.http.send();

    }
}