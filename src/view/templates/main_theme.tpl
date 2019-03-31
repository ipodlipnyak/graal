<html>
<head>
<link rel="icon" href="/favicon.svg" type="image/svg+xml" sizes="47x47">
<title>{{ title }}</title>
{% block head %}{% endblock %}
</head>
<body>
	<div id="app">
<!-- 	
  <b-navbar type="dark" variant="dark">
 
    <b-navbar-nav>
      <b-nav-item href="#">Home</b-nav-item>

      <b-nav-item-dropdown text="Lang" right>
        <b-dropdown-item href="#">EN</b-dropdown-item>
        <b-dropdown-item href="#">ES</b-dropdown-item>
        <b-dropdown-item href="#">RU</b-dropdown-item>
        <b-dropdown-item href="#">FA</b-dropdown-item>
      </b-nav-item-dropdown>

      <b-nav-item-dropdown text="User" right>
        <b-dropdown-item href="#">Account</b-dropdown-item>
        <b-dropdown-item href="#">Settings</b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>
  </b-navbar>
   -->
	{% block content %}{% endblock %}
	</div>
	<footer>

	{% block footer %}
		<script type="text/javascript" src="/assets/js/app_main.js"></script>
	{% endblock %}
	</footer>
</body>
</html>