import Vue from 'vue'
//import 'bootstrap';
import BootstrapVue from 'bootstrap-vue'

/* Promise based HTTP client */
import axios from 'axios';

import Carousel3d from 'vue-carousel-3d';

import VuePlyr from 'vue-plyr';
import 'vue-plyr/dist/vue-plyr.css';

import hammerjs from 'hammerjs'
import velocity from 'velocity-animate'
import KsVueFullpage from 'ks-vue-fullpage'
import 'ks-vue-fullpage/dist/ks-vue-fullpage.min.css';

//import Nav from 'bootstrap-vue/es/components/nav';
import Navbar from 'bootstrap-vue/es/components/navbar'

//import Eagle from 'faveeo-eagle.js/dist/eagle.es.js'
//import eagle.js default styles
//import 'faveeo-eagle.js/dist/eagle.css'
//import animate.css for slide transition 
//import 'animate.css'
//Vue.use(Eagle)
//Vue.component('slshow', slshow);

//import hello from './components/hello.vue';
//import slshow from './components/slshow.vue';

import blog from './components/blog.vue'
import post from './components/post.vue'
import login from './components/login.vue'

import 'bootstrap/dist/css/bootstrap.css';
import './../sass/main_public.scss';

import vueUrlParameters from 'vue-url-parameters';

//Vue.use(Carousel3d);
Vue.use(VuePlyr);
Vue.use(KsVueFullpage)

Vue.use(BootstrapVue);
Vue.use(Navbar)

Vue.component('blog',blog);
Vue.component('post',post);
Vue.component('login',login);



var app_main = new Vue({
	delimiters : [ '${', '}' ],
	el : '#app',
	mixins : [vueUrlParameters],
	data : {
		test: 'DickButt',
		testArray: ['dick','butt','ass','hole'],
		lambda: function () {
			return ['dick','butt','ass','hole'];
		},
		
		url_params: {},
		
		selected_post:'',
		
        sections: [
            {
            	sec_type: 'blog',
//            	bgColor: '#92457b',
            	bgColor: '#343a40',
            	name: 'Читальня',
            	link: 'blog'
            },
            {
            	sec_type: 'login',
            	bgColor: '#66bb6a',
            	name: 'Личный уголок',
            	link: 'login'
            },
            {
        		sec_type: 'text',
        		bgColor: '#42a5f5',
        		content: 'blah blah',
        		name: 'Конфа',
        		link: 'chat'
        	},
//            {
//            	sec_type: 'text',
//            	bgColor: '#66bb6a',
//            	content: 'login page'
//            }
//            {
//            	sec_type: 'img',
//            	bgColor: '#ec407a',
//            	content: 'I am section 1'
//            },
//            {
//            	sec_type: 'video',
//            	bgColor: '#42a5f5',
//            	content: 'I am section 2'
//            },
//            {
//            	sec_type: 'text',
//            	bgColor: '#66bb6a',
//            	content: 'I am section 3'
//            },
//            {
//            	sec_type: 'img',
//            	bgColor: '#ec9e40',
//            	content: 'I am section 4'
//            },

          ],
          options: {
        	  // Your custom options here
        	  duration: 800,
        	  overlay: false,
        	  dotNavEnabled: false,
//        	  animationType: 'slideX',
//        	  dotNavPosition: 'right',
        	  
        	  preloaderEnabled: true,
          },
          
          posts_list: [],
          post_in_slide: 0,
          
          postMenuClose: false,
          postTextBlack: true,

	},
	
	computed: {
//		navbar: function () {
//			var self = this;
//			self.sections.each(function(el){
//				
//			});
//		}
//	    show_submit_btn: function () {
//	    	if ((this.all_banners_selected == 1)&&(this.all_auto_selected == 1)){
//	    		return 1;
//	    	} else {
//	    		return 0;
//	    	}
//	    },
	},

	beforeCreate : function() {
		self = this;
		axios.get('/api/blog/get_posts')
		  .then(function (response) {
			  self.posts_list = response.data;
//			  self.$refs.blog[0].$refs.carousel.updateSlides();
		  })
		  .catch(function (error) {
			  console.log(error);
		  });
		
//		$.ajax({
//			method : "GET",
//			url : '/api/blog/get_posts',
//			success : function(msg) {
//				self.posts_list = msg;
//			}
//		});
	},
	
	created: function() {
		var self = this;
		self.url_params = self.getFiltersFromUrl(self.url_params);

	},
	
	updated : function() {
		self=this;
		
		/* listen when slide up/down start */
		/* @todo frecking glitching on slide up from first sub. What the heck it processing in that moment?! */
//	    self.$ksvuefp.$on('ksvuefp-change-begin', (nextIndex, oldIndex, direction, delay) => {
//	    	self.add_url_param('sub',nextIndex);
//	    });


	},
	mounted: function(){
		self=this;
		if ($(window).width() < 1700) {
			self.postMenuClose = true;
		}
		
	},
	watch : {
//		posts_list : function(){
//			self = this;
//			if (self.selected_post){
//				self.selected_post = self.posts_list.find(function(post) {
//					  return post.post_id = self.selected_post.post_id;
//				});
//			}
//		}
	},
	methods : {
		toggleTextColor: function() {
			var self = this;
			self.postTextBlack = !self.postTextBlack;
		},
		togglePostMenu: function() {
			var self = this;
			self.postMenuClose = !self.postMenuClose;
		},
        add_url_param : function(param_name,param_value) {
            var self = this;
            self.url_params[param_name] = param_value;
            self.updateUrlHash(self.url_params);
        },
		
		update_blog: function() {
			axios.get('/api/blog/get_posts')
			  .then(function (response) {
				  self.posts_list = response.data;
			  })
			  .catch(function (error) {
				  console.log(error);
			  });
		},
		gotoSection: function(nextIndex) {
			if (nextIndex === this.$ksvuefp.currentIndex) return
			this.$ksvuefp.$emit('ksvuefp-nav-click', { nextIndex })
		},
		
		select_post: function(post_id){
			var self = this;
			self.selected_post = post_id;
		},
		
		create_new_post : function(){
			self = this;
//			$.ajax({
//				method : "POST",
//				url : '/admin/new_post',
//				data : {
//					post_name : self.new_post.post_name,
//					post_text : self.new_post.post_text,
//					post_text_brief : self.new_post.post_text_brief
//				},
//				success : function(msg) {
//					if (self.new_post.files){
//						multiple_files_upload(msg.post_id,self.new_post.files[0]);
//					}
//					window.location.href = "/admin";
//				}
//			});
			
		},
		
	},
});

function multiple_files_upload(post_id, file){
	var data = new FormData();
//	var count_loaded_files = 0;
	data.append('ajax', 'upload_files');
	data.append('post_id', post_id);
	data.append('file[]', file);
	$.ajax({
//		indexValue: i,
		// Your server script to process the upload
		url : '/admin/upload_post_image',
		type : 'POST',

		// Form data
		data : data,

		// Tell jQuery not to process data or worry about content-type
		// You *must* include these options!
		cache : false,
		contentType : false,
		processData : false,
		
		complete: function(){
//			var new_count = parseInt($('#count-loaded-files').val(),10)+1;
//			$('#count-loaded-files').val(new_count);
//			
//			if ($('#count-loaded-files').val() == $('#count-query-files').val()){
//				send_email(message_id);
//				$("#auditionform #files-images p").text('Изображения загружены');
//			}
		},

		// Custom XMLHttpRequest
		xhr : function() {
			var myXhr = $.ajaxSettings.xhr();
//			myXhr.addEventListener("load", function(e){
//				if ((i+1) == $("#files-input").prop('files').length){
//					send_email(msg.new_request_id);
//				}
//			});
			if (myXhr.readyState)
			if (myXhr.upload) {
				// For handling the progress of the upload
				myXhr.upload.addEventListener('progress', function(e) {
					if (e.lengthComputable) {
						$('progress').attr({
							value : e.loaded,
							max : e.total,
						});
					}
				}, false);
			}
			return myXhr;
		}
	});
}

window.app_main = app_main;