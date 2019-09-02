<html>
<head>
<script type="text/javascript" async
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
</script>

</head>
<body style="color:#FF0000;">

<span id="eq1">$$A\left[n, m \right ] = \measuredangle \left \langle IFFT2 \left \{ \tilde{K}\left [ p, q \right ] \cdot \tilde{L}\left [p, q \right ] \cdot FFT2 \left \{ B\left [ n, m \right ] \right \} \right \}  \right \rangle$$</span>
<span id="eq2">$$\tilde{K} \left[p, q \right ] = e^{j \cdot \varphi \left[p, q \right ]}$$</span>
<span id="eq3">$$\varphi \left[p, q \right ]] = <?php echo $_GET["strength"]; ?>  \cdot \frac{<?php echo $_GET["warp"]; ?> \cdot r \cdot \arctan(<?php echo $_GET["warp"]; ?> \cdot r) - (1/2) \cdot \ln (1+(<?php echo $_GET["warp"]; ?> \cdot r)^{2})}{<?php echo $_GET["warp"]; ?> \cdot r_{max} \cdot \arctan(<?php echo $_GET["warp"]; ?> \cdot r_{max}) - (1/2) \cdot \ln (1 + (<?php echo $_GET["warp"]; ?> \cdot r_{max})^{2})}$$</span>

</body>
</html>

