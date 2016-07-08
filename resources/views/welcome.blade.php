<!DOCTYPE html>
<html lang="en">
<head>
	<head>
		<link rel="stylesheet" href="css/default.css" />
	</head>
	<body>
		<header>
			<h1>{{ $title }}</h1>
		</header>
		<nav>
			<ul>
				<li><a href="/affine">Афинна трансформация</a></li>
				<li><a href="/helmert">Хелмертова трансформация</a></li>
			</ul>
		</nav>
		<div class="main-wrapper">
			<main>
				<div id="main-content">
				    <section>
				    	<h2>{{ $transformation_type }}</h2>
				        <form method="post" action="/transformations" enctype="multipart/form-data">
				            <section>
				                <h3>Зареждане на XML файл</h3>
				                <div><input type="file" name="file" /></div>
				            </section>
				            <section>
				                <h3>Дименсия на грешките</h3>
				                <div>
				                    <select name="units">
				                        <option value="1">метри</option>
				                        <option value="2">дециметри</option>
				                        <option value="3">сантиметри</option>
				                        <option selected="selected" value="4">милиметри</option>
				                    </select>
				                </div>
				            </section>
				            <section>
				                <h3>Трансформация</h3>
				                <div>
				                    <input type="submit" name="submit" value="Трансформация" />
				                </div>
				            </section>
				        </form>
				    </section>
				</div>
				<aside></aside>
			</main>
		</div>
		<footer>
			<p>{{ $university }}</p>
			<p>{{ $department }}</p>
			<p>
				<span style="font-weight: bold;">{{ $master_thesis }}</span>
			</p>
			<p>{{ $thesis_title }}</p>
			<p>{{ $student_name }}, {{ $facility_number }}</p>
			<p><a href="http://validator.w3.org/check?uri=referer" target="_blank">Valid HTML 5</a></p>
		</footer>
	</body>
</html>