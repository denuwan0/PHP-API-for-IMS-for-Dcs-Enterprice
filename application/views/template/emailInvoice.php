<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Hardware Store - Weekly Specials</title>
    <style>
        /* Reset some default styles */
        body, p {
            margin: 0;
            padding: 0;
        }
        
        /* Set a background color and text color */
        body {
            background-color: #f2f2f2;
            color: #333;
            font-family: Arial, sans-serif;
        }
        
        /* Define the container for the email */
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Style the header section */
        .header {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            padding: 20px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        
        /* Style the main content section */
        .content {
            padding: 20px;
        }
        
        /* Style product listings */
        .product {
            margin-bottom: 20px;
        }
        .product img {
            max-width: 100%;
            height: auto;
        }
        .product h2 {
            margin-top: 10px;
        }
        
        /* Style the call-to-action button */
        .cta-button {
            text-align: center;
            margin-top: 20px;
        }
        .cta-button a {
            display: inline-block;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
        
        /* Add a footer with contact information */
        .footer {
            text-align: center;
            color: #777;
            font-size: 12px;
            padding-top: 20px;
        }
		table {
		  border-collapse: collapse;
		  border-spacing: 0;
		  width: 100%;
		  border: 1px solid #ddd;
		}

		th, td {
		  text-align: left;
		  padding: 16px;
		}

		tr:nth-child(even) {
		  background-color: #f2f2f2;
		}
		* {
		  box-sizing: border-box;
		}

		/* Create three equal columns that floats next to each other */
		.column {
		  float: left;
		  width: 33.33%;
		  padding: 10px;
		  height: 110px; /* Should be removed. Only for demonstration */
		}

		/* Clear floats after the columns */
		.row:after {
		  content: "";
		  display: table;
		  clear: both;
		}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>DCS Enterprices</h1>
        </div>
		<div class="row">
			<div class="column">
				<font size="2" >
				From:</br>
				<?=$company_name?>.</br>
				<?=$company_adress?></br>
				Phone: <?=$company_contact?></br>
				Email: <?=$company_email?>
				</font>
			</div>
			<div class="column">
				<font size="2">
				To:</br>
				<?=$customer_name?></br>
				<?=$customer_address?></br>
				Phone: <?=$customer_contact?></br>
				Email: <?=$customer_email?>
				</font>
			</div>
			<div class="column">
				<font size="2" style="font-weight:bold">
				Invoice: <?=$invoice_no?></br>
				Date: <?=$created_date?></br>	
				Order ID: <?=$order_no?></br>
				Status: <?=$status?>
				</font>
			</div>
		</div>
        <div class="content" style="overflow-x:auto;">
            <table>
			  <tr>
				<th>Item Name</th>
				<th>Description</th>
				<th style="text-align: right;">Qty</th>
				<th style="text-align: right;">Price</th>
			  </tr>
			  <tr>
				<td>Jill</td>
				<td>Smith</td>
				<td style="text-align: right;">50</td>
				<td style="text-align: right;">50</td>
			  </tr>
			  <tr>
				<td>Eve</td>
				<td>Jackson</td>
				<td style="text-align: right;">94</td>
				<td style="text-align: right;">50</td>
			  </tr>
			  <tr>
				<td>Adam</td>
				<td>Johnson</td>
				<td style="text-align: right;">67</td>
				<td style="text-align: right;">50</td>
			  </tr>
			  <tr>
				<th colspan="3" style="text-align: right;">Total</th>
				<th colspan="" style="text-align: right;">150</th>
			  </tr>
			</table>
        </div>
        <div class="cta-button">
            <a href="https://www.example.com/shop" target="_blank">Shop Now</a>
        </div>
        <div class="footer">
            <p>Contact Us: info@dcsenterprices.com | Phone: (123) 456-7890</p>
			<p>This is an system generated Email.</p>
            <p>&copy; 2023 DCS Enterprices. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
