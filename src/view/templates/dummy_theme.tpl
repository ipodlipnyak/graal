<html>
<head>
<link rel="icon" href="/favicon.svg" type="image/svg+xml" sizes="47x47">
<title>{{ title }}</title>
{% block head %}
{% endblock %}
</head>
<body>
	{% block content %}{% endblock %}
	<footer>
	{% block footer %}
		<script type="text/javascript" src="/assets/js/app_main.js"></script>
	{% endblock %}
	</footer>
</body>
</html>