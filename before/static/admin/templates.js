// This file was automatically generated from templates.soy.
// Please don't edit this file by hand.

if (typeof vitumob == 'undefined') { var vitumob = {}; }
if (typeof vitumob.admin == 'undefined') { vitumob.admin = {}; }


vitumob.admin.stylesheet = function(opt_data, opt_ignored) {
  return '\n\n\ttable { border: thin solid black; cursor: default }\n\n\ttbody.odd { background-color: WhiteSmoke }\n\n\ttbody.even { background-color: Gainsboro }\n\n\t#orders tbody:hover { background-color: LightSlateGray }\n\n\tth, td { padding: 5pt }\n\n\ttd.price { text-align: right }\n\n    thead td[id]:hover span { text-decoration: underline }\n\n    td.asc:after { content: \' \\2193\' }\n    td.desc:after { content: \' \\2191\' }\n\n';
};


vitumob.admin.order_tbody = function(opt_data, opt_ignored) {
  var output = '';
  var numberOfBundles__soy5 = opt_data.order.bundles.length;
  var bundleList6 = opt_data.order.bundles;
  var bundleListLen6 = bundleList6.length;
  for (var bundleIndex6 = 0; bundleIndex6 < bundleListLen6; bundleIndex6++) {
    var bundleData6 = bundleList6[bundleIndex6];
    output += '<tr data-host=\'' + soy.$$escapeHtml(bundleData6.host) + '\'>' + ((bundleIndex6 == 0) ? '<td rowspan=' + soy.$$escapeHtml(numberOfBundles__soy5) + '> ' + soy.$$escapeHtml(opt_data.order.id) + ' </td><td rowspan=' + soy.$$escapeHtml(numberOfBundles__soy5) + '> ' + soy.$$escapeHtml(opt_data.order.placed) + ' </td><td rowspan=' + soy.$$escapeHtml(numberOfBundles__soy5) + ' class=price> ' + soy.$$escapeHtml(opt_data.order.totalStr) + ' </td><td rowspan=' + soy.$$escapeHtml(numberOfBundles__soy5) + '> ' + ((opt_data.order.paid) ? ' ' + soy.$$escapeHtml(opt_data.order.paid) + ' ' : '') + ' </td>' : '') + '<td> ' + soy.$$escapeHtml(bundleData6.host) + ' </td><td> ' + soy.$$escapeHtml(bundleData6.items.length) + ' (' + soy.$$escapeHtml(bundleData6.itemCount) + ') </td><td class=\'price\'> $' + soy.$$escapeHtml(bundleData6.totalStr) + ' </td><td> ' + ((bundleData6.ordered) ? ' ' + soy.$$escapeHtml(bundleData6.ordered) + ' ' : '') + ' </td><td> ' + ((bundleData6.received) ? ' ' + soy.$$escapeHtml(bundleData6.received) + ' ' : '') + ' </td>' + ((bundleIndex6 == 0) ? '<td rowspan=' + soy.$$escapeHtml(numberOfBundles__soy5) + '> ' + ((opt_data.order.shipped) ? ' ' + soy.$$escapeHtml(opt_data.order.shipped) + ' ' : '') + ' </td><td rowspan=' + soy.$$escapeHtml(numberOfBundles__soy5) + '> ' + ((opt_data.order.arrived) ? ' ' + soy.$$escapeHtml(opt_data.order.arrived) + ' ' : '') + ' </td><td rowspan=' + soy.$$escapeHtml(numberOfBundles__soy5) + '> ' + ((opt_data.order.delivered) ? ' ' + soy.$$escapeHtml(opt_data.order.delivered) + ' ' : '') + ' </td>' : '') + '</tr>';
  }
  return output;
};


vitumob.admin.orders_table = function(opt_data, opt_ignored) {
  var output = '<table id=orders><thead><td id=id><span>#</span></td><td id=placed><span>Placed</span></td><td id=total class=price><span>Total KSh</span></td><td id=paid><span>Payment Received</span></td><td>Merchant</td><td>Items</td><td class=\'price\'>USD</td><td>Ordered</td><td>Received</td><td id=shipped><span>Shipped from US</span></td><td id=arrived><span>Arrived KE</span></td><td id=delivered><span>Delivered</span></td></thead>';
  var orderList85 = opt_data.orders;
  var orderListLen85 = orderList85.length;
  for (var orderIndex85 = 0; orderIndex85 < orderListLen85; orderIndex85++) {
    var orderData85 = orderList85[orderIndex85];
    output += '<tbody data-order=' + soy.$$escapeHtml(orderData85.id) + ' class=' + ((orderIndex85 % 2) ? ' odd ' : ' even ') + '>' + vitumob.admin.order_tbody({order: orderData85}) + '</tbody>';
  }
  output += '</table>';
  return output;
};


vitumob.admin.date_button = function(opt_data, opt_ignored) {
  return (opt_data.thing[opt_data.field]) ? '<span>' + soy.$$escapeHtml(opt_data.thing[opt_data.field]) + '</span>' : '<button>Mark ' + ((opt_data.label) ? soy.$$escapeHtml(opt_data.label) : soy.$$escapeHtml(opt_data.field)) + '</button>';
};


vitumob.admin.order_details = function(opt_data, opt_ignored) {
  var output = '\n<style>\n\n    #order-details { width: 60%; margin: 0 auto }\n    h1 { text-align: center }\n    #receipt { margin-left: 24pt }\n    h2 { font-weight: normal; margin-bottom: 6pt }\n    th { text-align: left; font-weight: normal }\n    td.price { text-align: right }\n    td.quantity { text-align: center }\n    textarea { width: 70% }\n\n</style>\n<div id=order-details><h1>Order #' + soy.$$escapeHtml(opt_data.order.id) + '<button id=receipt>Print Receipt</button></h1><div>Placed: ' + soy.$$escapeHtml(opt_data.order.placed) + '</div><div>Total: ' + soy.$$escapeHtml(opt_data.order.total) + ' KSh</div><div>Payment type: ' + soy.$$escapeHtml(opt_data.order.payment_type) + '</div><div id=\'paid\'><span>Payment Received: </span>' + ((opt_data.order.paid != null) ? soy.$$escapeHtml(opt_data.order.paid) : '') + '</div><h2>Customer Information</h2><div id=customer><div>Name: ' + soy.$$escapeHtml(opt_data.order.name) + '</div><div>Email: ' + soy.$$escapeHtml(opt_data.order.email) + '</div><div>Phone: ' + soy.$$escapeHtml(opt_data.order.phone) + '</div><div>Neighbourhood: ' + soy.$$escapeHtml(opt_data.order.neighbourhood) + '</div></div><h2>Items</h2><table><thead><td></td><td class=price>Price</td><td class=quantity>Quantity</td><td>Ordered</td><td>Received</td></thead>';
  var bundleList136 = opt_data.order.bundles;
  var bundleListLen136 = bundleList136.length;
  for (var bundleIndex136 = 0; bundleIndex136 < bundleListLen136; bundleIndex136++) {
    var bundleData136 = bundleList136[bundleIndex136];
    output += '<tbody data-bundle=\'' + soy.$$escapeHtml(bundleData136.host) + '\'><tr><th>' + soy.$$escapeHtml(bundleData136.merchant.name) + '</th><td></td><td></td><td id=\'' + soy.$$escapeHtml(bundleData136.host) + '-ordered\' rowspan=' + soy.$$escapeHtml(bundleData136.items.length + 1) + '></td><td id=\'' + soy.$$escapeHtml(bundleData136.host) + '-received\' rowspan=' + soy.$$escapeHtml(bundleData136.items.length + 1) + '></td></tr>';
    var itemList150 = bundleData136.items;
    var itemListLen150 = itemList150.length;
    for (var itemIndex150 = 0; itemIndex150 < itemListLen150; itemIndex150++) {
      var itemData150 = itemList150[itemIndex150];
      output += '<tr><td>' + soy.$$escapeHtml(itemData150.name) + '</td><td class=price>' + soy.$$escapeHtml(itemData150.price) + '</td><td class=quantity>' + soy.$$escapeHtml(itemData150.quantity) + '</td></tr>';
    }
    output += '</tbody>';
  }
  output += '</table><div id=\'shipped\'><span>Shipped from US: </span></div><div id=\'arrived\'><span>Arrived KE: </span></div><div id=\'delivered\'><span>Delivered to customer: </span></div><h2>Notes</h2><textarea id=notes>' + ((opt_data.order.notes != null) ? soy.$$escapeHtml(opt_data.order.notes) : '') + '</textarea></div>';
  return output;
};


vitumob.admin.receipt = function(opt_data, opt_ignored) {
  var output = '<!DOCTYPE HTML><html><head><title>VituMob: kila kitu kila siku</title><meta charset=\'utf-8\'>\n    <style>\n    \n    body {\n        background-image: url("http://www.vitumob.com/static/images/tag_background.png");\n        background-position: center;\n        background-repeat: no-repeat;\n        font-family: Helvetica, sans-serif\n    }\n\n    #header { text-align: center; height: 161px }\n    h1 { margin-top: 0; text-align: center; font-weight: normal; font-size: 24pt }\n    \n    #customer { font-size: 14pt; text-align: center; margin-bottom: 18pt }\n\n    table {\n        min-width: 50%;\n        margin: 0 auto;\n        border: thin dotted black;\n        border-spacing: 0;\n        padding: 12pt\n    }\n    \n    th { border-top: thin solid gray; padding-top: 12pt; text-align: left; font-weight: normal }\n\n    td { padding: 3pt }\n    td.price, tfoot td:first-child { text-align: right }\n    td.quantity { text-align: center }\n\n    tbody > tr:last-child > td { padding-bottom: 12pt }\n\n    tfoot > tr:first-child > td { border-top: double medium gray; padding-top: 12pt }\n    \n    p { width: 50%; margin: 28pt auto; font-size: smaller; text-align: center }\n\n    </style>\n    </head><body><div id=\'header\'><img id=\'logo\' src=\'http://www.vitumob.com/static/images/logo.png\'></div><h1>Order #' + soy.$$escapeHtml(opt_data.order.id) + '</h1><div id=customer><div>' + soy.$$escapeHtml(opt_data.order.name) + '</div><div>' + soy.$$escapeHtml(opt_data.order.phone) + '</div><div>' + soy.$$escapeHtml(opt_data.order.email) + '</div></div><table><thead><td></td><td class=price>Price KSh</td><td class=quantity>Quantity</td></thead>';
  var bundleList176 = opt_data.order.bundles;
  var bundleListLen176 = bundleList176.length;
  for (var bundleIndex176 = 0; bundleIndex176 < bundleListLen176; bundleIndex176++) {
    var bundleData176 = bundleList176[bundleIndex176];
    output += '<tbody data-bundle=\'' + soy.$$escapeHtml(bundleData176.host) + '\'><tr><th>' + soy.$$escapeHtml(bundleData176.merchant.name) + '</th><th></th><th></th></tr>';
    var itemList182 = bundleData176.items;
    var itemListLen182 = itemList182.length;
    for (var itemIndex182 = 0; itemIndex182 < itemListLen182; itemIndex182++) {
      var itemData182 = itemList182[itemIndex182];
      output += '<tr><td>' + soy.$$filterNoAutoescape(itemData182.name) + '</td><td class=price>' + soy.$$escapeHtml(itemData182.priceStrKES) + '</td><td class=quantity>' + soy.$$escapeHtml(itemData182.quantity) + '</td></tr>';
    }
    output += '</tbody>';
  }
  output += '<tfoot><tr><td>Subtotal</td><td class=price>' + soy.$$escapeHtml(opt_data.order.subtotalStr) + '</td><td></td></tr><tr><td>Customs</td><td class=price>' + soy.$$escapeHtml(opt_data.order.customsStr) + '</td><td></td></tr><tr><td>Shipping</td><td class=price>' + soy.$$escapeHtml(opt_data.order.shippingStr) + '</td><td></td></tr><tr><td>VAT</td><td class=price>' + soy.$$escapeHtml(opt_data.order.vatStr) + '</td><td></td></tr><tr><td>Total</td><td class=price>' + soy.$$escapeHtml(opt_data.order.totalStr) + '</td><td></td></tr></tfoot></table><p>All sales are final upon delivery. If you have any questions about your order, please contact us at orders@vitumob.com or 0720-583095.</p></body></html>';
  return output;
};