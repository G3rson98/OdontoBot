<?php

 function get_Historial($persona,$paciente,$patologia){
 	 	$nombre=$persona["nombre_per"]." ".$persona["paterno"]." ".$persona["materno"];
		$plantilla='
	<header class="clearfix">
		<div class="container">
			<figure>
				<img class="logo" src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjM5cHgiIGhlaWdodD0iMzFweCIgdmlld0JveD0iMCAwIDM5IDMxIiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIj4KICAgIDwhLS0gR2VuZXJhdG9yOiBTa2V0Y2ggMy40LjEgKDE1NjgxKSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5ob21lNDwvdGl0bGU+CiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4KICAgIDxkZWZzPjwvZGVmcz4KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPgogICAgICAgIDxnIGlkPSJJTlZPSUNFLTEiIHNrZXRjaDp0eXBlPSJNU0FydGJvYXJkR3JvdXAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00Mi4wMDAwMDAsIC00NS4wMDAwMDApIiBmaWxsPSIjRkZGRkZGIj4KICAgICAgICAgICAgPGcgaWQ9IlpBR0xBVkxKRSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAxNS4wMDAwMDApIj4KICAgICAgICAgICAgICAgIDxnIGlkPSJob21lNCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTIuMDAwMDAwLCAzMC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNTaGFwZUdyb3VwIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMzguMjc5MzM1LDE0LjAzOTk1MiBMMzIuMzc5MDM3OCw5LjAxMjMzODM1IEwzMi4zNzkwMzc4LDMuMjA0MzM2NzQgQzMyLjM3OTAzNzgsMi4xNTQ0MTY1MyAzMS4zODA1NTkyLDEuMzAzMjk3MjggMzAuMTQ2MDE3NiwxLjMwMzI5NzI4IEMyOC45MTQ2MTk2LDEuMzAzMjk3MjggMjcuOTE2MTQxMSwyLjE1NDQxNjUzIDI3LjkxNjE0MTEsMy4yMDQzMzY3NCBMMjcuOTE2MTQxMSw1LjIwOTMzODY1IEwyMy41MjI2OTc3LDEuNDY1NzY5OTggQzIxLjM1MDM4NzksLTAuMzgzODc0MjAyIDE3LjU3MzY3NTEsLTAuMzgwNjA5NjggMTUuNDA2NjcsMS40NjkwMzQ1IEwwLjY1MzA3ODA4NiwxNC4wMzk5NTIgQy0wLjIxNzU5NDQ1OCwxNC43ODM1MDk1IC0wLjIxNzU5NDQ1OCwxNS45ODY3Nzg1IDAuNjUzMDc4MDg2LDE2LjcyODk5NjYgQzEuNTI0NjM0NzYsMTcuNDcyNTU0MSAyLjkzOTQ0MDgxLDE3LjQ3MjU1NDEgMy44MTAxMTMzNSwxNi43Mjg5OTY2IEwxOC41NjIxMzM1LDQuMTU4MDc5MTUgQzE5LjA0MzAwMjUsMy43NTA2ODM2NSAxOS44ODk5MDE4LDMuNzUwNjgzNjUgMjAuMzY4MDIwMiw0LjE1NjgyMzU2IEwzNS4xMjIyOTk3LDE2LjcyODk5NjYgQzM1LjU2MDE0MTEsMTcuMTAwNzMzNSAzNi4xMzA0MDU1LDE3LjI4NTgwNjcgMzYuNzAwNjcsMTcuMjg1ODA2NyBDMzcuMjcyMDE1MSwxNy4yODU4MDY3IDM3Ljg0MzQ1ODQsMTcuMTAwNzMzNSAzOC4yNzk3MjgsMTYuNzI4OTk2NiBDMzkuMTUwNzkzNSwxNS45ODY3Nzg1IDM5LjE1MDc5MzUsMTQuNzgzNTA5NSAzOC4yNzkzMzUsMTQuMDM5OTUyIEwzOC4yNzkzMzUsMTQuMDM5OTUyIFoiIGlkPSJGaWxsLTEiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMjAuMjQxMzkyOSw3Ljc2Njk2NTM5IEMxOS44MTI3ODU5LDcuNDAyMDA4NjcgMTkuMTE4OTM5NSw3LjQwMjAwODY3IDE4LjY5MTUxMTMsNy43NjY5NjUzOSBMNS43MTQyMzY3OCwxOC44MjEzMDM2IEM1LjUwOTMxNDg2LDE4Ljk5NTU3ODggNS4zOTMzOTU0NywxOS4yMzM5NzI1IDUuMzkzMzk1NDcsMTkuNDgyNDEwOSBMNS4zOTMzOTU0NywyNy41NDUzNTk2IEM1LjM5MzM5NTQ3LDI5LjQzNzE5MTQgNy4xOTM1ODQzOCwzMC45NzEwMTQxIDkuNDEzODMzNzUsMzAuOTcxMDE0MSBMMTUuODM4NzE1NCwzMC45NzEwMTQxIEwxNS44Mzg3MTU0LDIyLjQ5MjU1MDUgTDIzLjA5MjUxODksMjIuNDkyNTUwNSBMMjMuMDkyNTE4OSwzMC45NzEwMTQxIEwyOS41MTc4OTE3LDMwLjk3MTAxNDEgQzMxLjczODE0MTEsMzAuOTcxMDE0MSAzMy41MzgyMzE3LDI5LjQzNzE5MTQgMzMuNTM4MjMxNywyNy41NDUzNTk2IEwzMy41MzgyMzE3LDE5LjQ4MjQxMDkgQzMzLjUzODIzMTcsMTkuMjMzOTcyNSAzMy40MjMwOTgyLDE4Ljk5NTU3ODggMzMuMjE3NDg4NywxOC44MjEzMDM2IEwyMC4yNDEzOTI5LDcuNzY2OTY1MzkgWiIgaWQ9IkZpbGwtMyI+PC9wYXRoPgogICAgICAgICAgICAgICAgPC9nPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4=" alt="">
			</figure>
			<div class="company-address">
				<h2 class="title">Consultorio Dr Robles</h2>
				<p>
					455 Foggy Heights,<br>
					AZ 85004, US
				</p>
			</div>
		
				<div class="email right">
					<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt=""><span class="helper"></span></span>
					<a href="mailto:company@example.com">company@example.com</a>
					<span class="helper"></span>
				</div>
			</div>
		</div>
	</header>

	<section>
		<div class="container">
			<div class="details clearfix">
				<div class="client left">
					<p>PACIENTE:</p>
					<p class="name">'.$nombre.'</p>
					<p>Ci:'.$persona["ci"].'</p>
					<p>telefono:'.$persona["telefono"].'"</p>
					<p>celular:'.$persona["celular"].'</p>
					<p>Direccion:'.$persona["direccion"].'</p>
					<p>Fecha Nacimiento:'.$persona["fecha_nac"].'</p>
					<p>Lugar De Nacimiento:'.$paciente["lugar_nac"].'</p>
					<a href="mailto:john@example.com">john@example.com</a>
				</div>
				<div class="data right">
					<div class="title">HISTORIAL</div>
					<div class="date">
						Date of Invoice: 01/06/2014<br>
						Due Date: 30/06/2014
					</div>
				</div>
			</div>

			<table border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th class="desc">Description</th>
						<th class="qty">Quantity</th>
						<th class="unit">Unit price</th>
						<th class="total">Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="desc"><h3>Website Design</h3>Creating a recognizable design solution based on the companys existing visual identity</td>
						<td class="qty">30</td>
						<td class="unit">$40.00</td>
						<td class="total">$1,200.00</td>
					</tr>
					<tr>
						<td class="desc"><h3>Website Development</h3>Developing a Content Management System-based Website</td>
						<td class="qty">80</td>
						<td class="unit">$40.00</td>
						<td class="total">$3,200.00</td>
					</tr>
					<tr>
						<td class="desc"><h3>Search Engines Optimization</h3>Optimize the site for search engines (SEO)</td>
						<td class="qty">20</td>
						<td class="unit">$40.00</td>
						<td class="total">$800.00</td>
					</tr>
				</tbody>
			</table>
			<div class="no-break">
				<table class="grand-total">
					<tbody>
						<tr>
							<td class="desc"></td>
							<td class="qty"></td>
							<td class="unit">SUBTOTAL:</td>
							<td class="total">$5,200.00</td>
						</tr>
						<tr>
							<td class="desc"></td>
							<td class="qty"></td>
							<td class="unit">TAX 25%:</td>
							<td class="total">$1,300.00</td>
						</tr>
						<tr>
							<td class="desc"></td>
							<td class="unit" colspan="2">GRAND TOTAL:</td>
							<td class="total">$6,500.00</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</body>
';
return $plantilla;
	
}
?>