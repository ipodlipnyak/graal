<template>
<div :style="postTextStyle">
	<sidebar-menu :style="sideMenuStyle" :collapsed="collapsed" show-child
		:menu="menu"></sidebar-menu>

	<div :style="post_content_style" class="post-body">
		<div class="row">
			<h1>{{ post.post_name }}</h1>
		</div>

		<div class="row">
			<div class='col-md-12' v-html="post.post_text"></div>
		</div>
	</div>

</div>
</template>

<script>
import axios from 'axios';
// import { Slide } from 'vue-burger-menu';
import { SidebarMenu } from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'

export default {
		name : 'post',
	    props: {
	    	textBlack: {
	    		type: Boolean,
	    		default: true
	    	},
	    	post_id: {
    			type: Number,
    		},
    		collapsed: {
    	        type: Boolean,
            	default: false
    		},
    	},
		data : function() {
			return {
				post : {
					post_name: 'dummy',
				},
			}
		},
	    components: {
	    	SidebarMenu,
	    },
		computed: {
			winHeight: function(){
				return $(window).height();
			},
			winWidth: function(){
				return $(window).width();
			},
			sideWidth: function(){
				return this.collapsed || $(window).width() < 1000 ? 75 : 400;
// 				return $('.vsm-list').width();
			},
			postTextMaxWidth: function(){
				return $(window).width() - this.sideWidth + 'px';
			},
			sideMenuStyle: function(){
				var padding = $('#nav-header').height() + 'px';
				return {
					top: padding
				}
			},
			postTextStyle: function() {
				var black = '#323236'; 
				var white = 'white';
				var paddingTop = $('#nav-header').height() + 'px';
				var bgColor = this.textBlack ? white : black;
				var txtColor = this.textBlack ? black : white;
				var result = {
						backgroundColor: bgColor,
						color: txtColor,
						paddingTop: paddingTop,
					};

				return result;
			},
		    post_content_style: function () {
// 		    	var maxWidth = $(window).width() - $('.vsm-list').width() + 'px';
// 		    	var maxWidth = '1554px';
		    	var result = {
		    		height: window.innerHeight - 100,
		    		overflow: 'scroll',
		    		paddingLeft: '25px',
		    		maxWidth: this.postTextMaxWidth
		    		
		    	};
// 				if ($(window).width() < 1000) {
// 					result["paddingLeft"] = '75px';
// 					result["paddingRight"] = '25px';
// 				}
				
		    	return result;
		    },
		    
		    menu: function (){
		    	return [
	                {
	                    header: true,
	                    title: this.post.post_name,
	                    // component: componentName
	                    // visibleOnCollapse: true
	                },
					{
	                    href: '#',
	                    title: 'Charts',
	                    icon: 'FUCK',
	                    child: [
	                        {
	                            href: '#',
	                            title: 'Sub Link',
	                        }
	                    ]
					},
				];
		    },
		    
		},
		created: function() {
			var self = this;
    		axios.get('/api/blog/get_posts/'+self.post_id)
    		  .then(function (response) {
    			  self.post = response.data;
    		  })
    		  .catch(function (error) {
    			  console.log(error);
    		  });

		},
		watch : {
			post_id : function(new_val,old_val){
				var self = this;
				self.load_post(new_val);
			}
		},
	    methods: {
	        load_post: function(post_id) {
	    		var self = this;
	    		axios.get('/api/blog/get_posts/'+self.post_id)
	    		  .then(function (response) {
	    			  self.post = response.data;
	    		  })
	    		  .catch(function (error) {
	    			  console.log(error);
	    		  });
	        }
		},
	}
</script>

<style scoped>
/*
.v-sidebar-menu {
	top: 56px;
}
*/
@media ( max-width : 991.98px) {
	.v-sidebar-menu .vsm-link {
		font-size: 2rem;
	}
	/*
	.post-body {
		padding-left: 70px;
	}
	*/
}

.post-body {
	padding-top: 56px;
	padding-bottom: 56px;
	margin-left:auto;
}
</style>
