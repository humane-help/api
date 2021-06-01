window.ontpchat = new (function() {
	
	var _this = this;
	var botCmdAddress = "http://194.58.119.193:8032/";
	
	var aside_feedback = document.querySelector("aside.aside-feedback");
	var nav_points = aside_feedback.querySelector(".nav-points");
	
	var ontpchat_feed = document.querySelector(".feed-inpage");
	var ontpchat_body = document.querySelector(".chat-inpage");
	var ontpchat_msgtext = ontpchat_body.querySelector(".chat-form__input");
	//var ontpchat_btnfile = document.querySelector("#ontpchat_footer .ontpchat_button.ontpchat_sendfile");
	//var ontpchat_btnmsg = document.querySelector("#ontpchat_footer .ontpchat_button.ontpchat_sendmsg");
	
	var ontpchat_msglist = document.querySelector(".chat-inpage__body");
	
	var message_template = ontpchat_body.querySelector(".chat-message__templates .chat-message__notmy");
	var mymessage_template = ontpchat_body.querySelector(".chat-message__templates .chat-message__my");
	
	var myname = (~~((Math.random() + 0.5) * 987654321)).toString(36);
    
    var updatesIsRun = false;
	
	this.pushMsg = function(text, isMyMessage) {
		var el = isMyMessage ? mymessage_template.cloneNode(true) : message_template.cloneNode(true);
		console.log(el, el.children);
		el.querySelector(".chat-message__text").innerHTML = text.replace(/\n/g, "<br>");
		ontpchat_msglist.appendChild(el);
		ontpchat_msglist.scrollTop = ontpchat_msglist.scrollHeight;
	}
	
	this.sendMsg = function() {
		var txt = ontpchat_msgtext.value.trim();
		if(!txt) return;
		
        if(!updatesIsRun) {
            updatesIsRun = true;
            this.getUpdates();
        }
        
		txt = txt.replace(/\&/g, "&amp;").replace(/\</g, "&lt;").replace(/\>/g, "&gt;");
		
		var xhr = new XMLHttpRequest();
		xhr.open('GET', botCmdAddress+'send?'+encodeURIComponent(myname)+';'+encodeURIComponent(txt), true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				if(xhr.status == 200) {
					ontpchat_msgtext.value = "";
					ontpchat_msgtext.oninput();
					_this.pushMsg(txt, true);
				} else {
					alert("HTTP ERROR! Status: "+xhr.status);
				}
				ontpchat_msgtext.disabled = false;
				ontpchat_body.style.cursor = "";
				ontpchat_msgtext.focus();
			}
		};
		xhr.send();
		ontpchat_msgtext.disabled = true;
		ontpchat_body.style.cursor = "wait !important";
	}
	
	this.sendFile = function(file){
		if(!file || !myname) return;
		
		if(file.size>1048576*3) {
			alert("Размер файла не должен превышать 3 MB");
			return;
		}
        
        if(!updatesIsRun) {
            updatesIsRun = true;
            this.getUpdates();
        }
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', botCmdAddress+'sendfile', true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				if(xhr.status == 200) {
					_this.pushMsg("<div class=\"ontpchat_filemsg\">«"+file.name+"»</div>", true);
				} else {
					alert("HTTP ERROR! Status: "+xhr.status);
				}
				ontpchat_msgtext.disabled = false;
				ontpchat_body.style.cursor = "";
				//ontpchat_msgtext.focus();
			}
		};
		
		var fd  = new FormData();
		fd.append("username", myname);
		fd.append("file", file);
		
		xhr.send(fd);
		ontpchat_msgtext.disabled = true;
		ontpchat_body.style.cursor = "wait !important";
	}
	
	var gettingUpdates = false;
	this.getUpdates = function() {
		gettingUpdates = true;
		var xhr = new XMLHttpRequest();
		xhr.open('GET', botCmdAddress+'read?'+encodeURIComponent(myname), true); 
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				if(xhr.status == 200) {
					console.log(xhr.responseText);
					var arr = JSON.parse(xhr.responseText);
					arr.forEach(function(txt) {
						_this.pushMsg(txt.replace(/\&/g, "&amp;").replace(/\</g, "&lt;").replace(/\>/g, "&gt;"));
					});
				}
				gettingUpdates =  false;
				//if(ontpchat_container.classList.contains("ontpchat_open"))
					setTimeout(function(){_this.getUpdates()}, 1000);
			}
		};
		xhr.send();
	}
	
	ontpchat_msgtext.onkeypress = function(event) {
		//console.dir(event);
		if(event.keyCode == 13 && !event.shiftKey) {
			_this.sendMsg();
			return false;
		}
	}
	
	ontpchat_msgtext.oninput = function() {
		//msg_text.style.height = 0;
		//msg_text.style.height = msg_text.scrollHeight + "px";
		//ontpchat_footer.style.flexBasis = 0;
		//ontpchat_footer.style.flexBasis = ontpchat_msgtext.scrollHeight + "px";
		
		/*if(myname) {
			if(ontpchat_msgtext.value) {
				ontpchat_button.classList.remove("sendfile");
				ontpchat_button.classList.add("sendmsg");
			} else {
				ontpchat_button.classList.remove("sendmsg");
				ontpchat_button.classList.add("sendfile");
			}
		}*/
	}
	
	var inputFileElement = document.createElement("input");
	inputFileElement.type = "file";
	inputFileElement.onchange = function() {
		if(inputFileElement.files.length = 0) return;
		_this.sendFile(inputFileElement.files[0]);
		inputFileElement.value="";
	}
	
	this.openFileDialog = function() {
		inputFileElement.click();
	}
	
	ontpchat_body.querySelector(".chat-form__sendfile").onclick = function() {
		aside_feedback.querySelector(".chat-inpage__body .chat-empty").classList.add("hidden");
		inputFileElement.click();
	}
	
	this.sendFeedback = function() {
		var name = ontpchat_feed.querySelector('.feed-inpage__input[name="name"]').value;
		var companyname = ontpchat_feed.querySelector('.feed-inpage__input[name="companyname"]').value;
		var phone = ontpchat_feed.querySelector('.feed-inpage__input[name="phone"]').value;
		var email = ontpchat_feed.querySelector('.feed-inpage__input[name="email"]').value;
		var markcheck = ontpchat_feed.querySelector('.check-mark__input[name="mark"]').checked;
		
		if(!markcheck) {
			return;
		}
		
		var txt = "[ПЕРЕЗВОНИТЕ МНЕ]\r\n" +
		"Имя: " + name + "\r\n" +
		"Компания: " + companyname + "\r\n" +
		"Телефон: " + phone + "\r\n" +
		"E-Mail: " + email;
		
		var xhr = new XMLHttpRequest();
		xhr.open('GET', botCmdAddress+'send?'+encodeURIComponent(myname)+';'+encodeURIComponent(txt), true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				if(xhr.status == 200) {
					alert("Спасибо за обращение! В ближайшее время мы с вами свяжемся.");
					ontpchat_feed.querySelector('.feed-inpage__input[name="name"]').value =
					ontpchat_feed.querySelector('.feed-inpage__input[name="companyname"]').value =
					ontpchat_feed.querySelector('.feed-inpage__input[name="phone"]').value =
					ontpchat_feed.querySelector('.feed-inpage__input[name="email"]').value = "";
					ontpchat_feed.querySelector(".terms-label__input.check-mark").classList.remove('selected');
					ontpchat_feed.querySelector('.check-mark__input[name="mark"]').checked = false;
					aside_feedback.attributes['inpage'].value = 0;
				} else {
					alert("HTTP ERROR! Status: "+xhr.status);
				}
			}
		};
		xhr.send();
	}
	
	this.sendFeedback2 = function(form) {
		
		var type = form.elements.type.value;
		var inn = form.elements.inn.value;
		var phone = form.elements.phone.value;
		var email = form.elements.email.value;
		var nds = form.elements.nds.value;
		
		var txt = "\r\n--------------------------------\r\n[ЗАЯВКА С ГЛАВНОЙ СТРАНИЦЫ]\r\n" +
		"Тип: " + (type=='ip' ? 'ИП' : type=='yur' ? 'Юр. лицо' : type=='nerez' ? 'Нерезидент' : 'Unknown') + "\r\n" +
		"ИНН: " + inn + "\r\n" +
		"Телефон: " + phone + "\r\n" +
		"E-Mail: " + email + "\r\n" +
		"Плательщик НДС: " + (nds=='1' ? 'Да' : 'Нет')
		+ "\r\n--------------------------------\r\n";
		
		var xhr = new XMLHttpRequest();
		xhr.open('GET', botCmdAddress+'send?'+encodeURIComponent(myname)+';'+encodeURIComponent(txt), true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				if(xhr.status == 200) {
					alert("Спасибо за обращение! В ближайшее время мы с вами свяжемся.");
					form.elements.inn.value = "";
					form.elements.phone.value = "";
					form.elements.email.value = "";
				} else {
					alert("HTTP ERROR! Status: "+xhr.status);
				}
			}
		};
		xhr.send();
	}
	
	this.sendFeedback3 = function(form) {
		
		var type = form.elements.type.value;
		var inn = form.elements.inn.value;
		var phone = form.elements.phone.value;
		var email = form.elements.email.value;
		var nds = form.elements.nds.value;
		var name1 = form.elements.name1.value;
		var name2 = form.elements.name2.value;
		var name3 = form.elements.name3.value;
		
		var txt = "\r\n--------------------------------\r\n[ЗАЯВКА С ТАРИФНОЙ СТРАНИЦЫ]\r\n" +
		"Тип: " + (type=='ip' ? 'ИП' : type=='yur' ? 'Юр. лицо' : type=='nerez' ? 'Нерезидент' : 'Unknown') + "\r\n" +
		"ФИО: " + name2+' '+name1+' '+name3 + "\r\n" +
		"ИНН: " + inn + "\r\n" +
		"Телефон: " + phone + "\r\n" +
		"E-Mail: " + email + "\r\n" +
		"Плательщик НДС: " + (nds=='1' ? 'Да' : 'Нет')
		+ "\r\n--------------------------------\r\n";
		
		var xhr = new XMLHttpRequest();
		xhr.open('GET', botCmdAddress+'send?'+encodeURIComponent(myname)+';'+encodeURIComponent(txt), true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				if(xhr.status == 200) {
					alert("Спасибо за обращение! В ближайшее время мы с вами свяжемся.");
					form.elements.inn.value = "";
					form.elements.phone.value = "";
					form.elements.email.value = "";
					form.elements.name1.value = "";
					form.elements.name2.value = "";
					form.elements.name3.value = "";
				} else {
					alert("HTTP ERROR! Status: "+xhr.status);
				}
			}
		};
		xhr.send();
	}
	/*document.querySelector('form.send-form__form.request-form').onsubmit = function(e) {
		e.preventDefault();
		ontpchat.sendFeedback2();
		return false;
	};*/
	
	Array.from(document.querySelectorAll('form.ontpchat_form1'))
		.forEach(function(form){
			form.onsubmit = function(e) {
				e.preventDefault();
				ontpchat.sendFeedback2(form);
				return false;
			}
		});
	
	Array.from(document.querySelectorAll('form.ontpchat_form2'))
		.forEach(function(form){
			form.onsubmit = function(e) {
				e.preventDefault();
				ontpchat.sendFeedback3(form);
				return false;
			}
		});
	
	ontpchat_feed.querySelector('.feed-inpage__button').onclick = function() {
		_this.sendFeedback();
	}
	
	aside_feedback.querySelector(".nav-points__item--phone")
		.onclick = function() {
			aside_feedback.attributes['inpage'].value = 1;
		};
	aside_feedback.querySelector(".nav-points__item--message")
		.onclick = function() {
			aside_feedback.attributes['inpage'].value = 2;
		}
	aside_feedback.querySelector(".nav-points__item--close")
		.onclick = function() {
			nav_points.classList.toggle('nav-points__hide');
		};
	for(var a = aside_feedback.querySelectorAll(".inpage-aside__close, .aside-feedback_overlay"), i=0; i<a.length; ++i) {
		a[i].onclick = function() {
			aside_feedback.attributes['inpage'].value = 0;
		};
	}
	aside_feedback.querySelector(".chat-form__input")
		.onfocus = function() {
			aside_feedback.querySelector(".chat-inpage__body .chat-empty").classList.add("hidden");
		};
	aside_feedback.querySelector(".terms-label__input.check-mark")
		.onclick = function() {
			this.classList.toggle("selected");
			this.querySelector('input.check-mark__input').checked = this.classList.contains("selected");
			return false;
		};
	
	for(var a = document.querySelectorAll(".footer__button-call, .footer__button-feed"), i=0; i<a.length; ++i) {
		a[i].onclick = function() {
			aside_feedback.attributes['inpage'].value = 1;
			return false;
		};
	}
	
	for(var a = document.querySelectorAll(".ontpchat-open-messenger"), i=0; i<a.length; ++i) {
		a[i].onclick = function() {
			aside_feedback.attributes['inpage'].value = 2;
			return false;
		};
	}
	
})();