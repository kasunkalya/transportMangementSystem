
{{ $error_level = error_reporting() }}
{{ error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING) }}

<html><head></head><body>
{{ $data }}
</body>
</html>
{{ error_reporting($error_level)}}