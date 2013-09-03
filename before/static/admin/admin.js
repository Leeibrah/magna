var style = document.createElement('style');
style.innerText = vitumob.admin.stylesheet();
document.head.appendChild(style);

Date.prototype.toString = Date.prototype.toLocaleDateString;

//function withCommas(x) {
//    return parseFloat(Math.round(x * 100) / 100).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")
//}
//var kes = withCommas;
//function usd(x) { return "$" + withCommas(x) }


function setDate(thing, date, del) {
    var xhr = new XMLHttpRequest();
    if (thing.order)
        xhr.open((del ? "DELETE" : "POST"), "https://" + window.location.host + "/admin/orders/" + thing.order.id + "/bundle/" + thing.host + "/" + date, true);
    else
        xhr.open((del ? "DELETE" : "POST"), "https://" + window.location.host + "/admin/orders/" + thing.id + "/" + date, true);
    xhr.withCredentials = true;
    xhr.send();
}

function buttonOrText(thing, date) {

    function span() {
        var s = document.createElement('span');
        s.appendChild(document.createTextNode(thing[date].toLocaleDateString()));
        s.addEventListener('click', function() {
            if (window.confirm("Remove this date?")) {
                thing[date] = null;
                setDate(thing, date, true);
                s.parentNode.insertBefore(button(), s);
                s.parentNode.removeChild(s);
            }
        }, false);
        return s;
    }
    function button() {
        var b = document.createElement('button');
        b.innerHTML = "Mark " + date;
        b.addEventListener('click', function() {
            thing[date] = new Date();
            setDate(thing, date);
            b.parentNode.insertBefore(span(), b);
            b.parentNode.removeChild(b);
        }, false);
        return b;
    }
    return thing[date] ? span() : button();
}

/*
order.bundles.reduce(function(allReceived, bundle) { return allReceived && bundle.received }, true)
*/


function showOrderDetails(order, tbody) {
    document.body.innerHTML = vitumob.admin.order_details({order:order});
    document.getElementById('receipt').addEventListener('click', function() { window.open().document.write(vitumob.admin.receipt({order:order})); }, false);
    order.bundles.forEach(function(bundle) {
        document.getElementById(bundle.host+'-ordered').appendChild(buttonOrText(bundle, 'ordered'));
        document.getElementById(bundle.host+'-received').appendChild(buttonOrText(bundle, 'received'));
    });
    document.getElementById('shipped').appendChild(buttonOrText(order, 'shipped'));
    document.getElementById('arrived').appendChild(buttonOrText(order, 'arrived'));
    document.getElementById('delivered').appendChild(buttonOrText(order, 'delivered'));
    var notes = document.getElementById('notes');
    notes.addEventListener('change', function() {
        var xhr = new XMLHttpRequest();
        xhr.open('PUT', "https://" + window.location.host + "/admin/orders/" + order.id + "/notes", true);
        xhr.withCredentials = true;
        xhr.send(notes.value);
    }, false);
}

var comps = {};
['id', 'placed', 'total', 'paid', 'shipped', 'arrived', 'delivered'].forEach(function(field) {
    comps[field] = {
        'asc': function(o1, o2) { return o1[field] ? (o2[field] ? o1[field] - o2[field] : -1) : 1 },
        'desc': function(o1, o2) { return o1[field] ? (o2[field] ? o2[field] - o1[field] : -1) : 1 }
    }
});

function displayOrderTable(orders, sortField, asc) {
    var os = orders.filter(function(o) { return o; });
    if (sortField)
        os.sort(comps[sortField][asc ? 'asc' : 'desc']);
    document.body.innerHTML = vitumob.admin.orders_table({orders:os});
    ['id', 'placed', 'total', 'paid', 'shipped', 'arrived', 'delivered'].forEach(function(field) {
        var td = document.getElementById(field);
        if (sortField == field)
            td.classList.add(asc ? 'asc' : 'desc');
        td.addEventListener('click', function() {
            displayOrderTable(orders, field, sortField == field && !asc);
            history.pushState({field:field}, null, "/admin/orders/" + field + ((sortField == field && !asc) ? '/asc' : '/desc'));
        }, false);
    });
    document.getElementById('orders').addEventListener('click', function(e) {
        var getTBody = function(ele) {
            if (ele.tagName == 'TBODY') return ele;
            if (!ele.parentNode) return null;
            return getTBody(ele.parentNode);
        };
        var tbody = getTBody(e.target);
        if (tbody) {
            var orderId = parseInt(tbody.getAttribute('data-order'), 10);
            var order = orders[orderId];
            showOrderDetails(order, tbody);
            history.pushState({order:order.id}, null, "/admin/orders/" + order.id);
        }
    }, false);
}

function route() {
    var path = window.location.pathname.split('/');
    path.shift(); path.shift();
    switch (path[0]) {
        case 'orders':
            if (path.length == 1)
                displayOrderTable(orders);
            else {
                if (/^\d+$/.test(path[1]))
                    showOrderDetails(orders[parseInt(path[1])]);
                else if (['id', 'placed', 'total', 'paid', 'shipped', 'arrived', 'delivered'].indexOf(path[1].toLowerCase() != -1)) {
                    var asc = path.length == 3 && path[2].toLowerCase() == 'asc';
                    displayOrderTable(orders, path[1].toLowerCase(), asc);
                }
            }
            break;
        case 'setpass':
            document.body.innerHTML = vitumob.admin.set_pass();
            break;
        default:
            displayOrderTable(orders);
    }
}

var orders = [];

function loadOrders(callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "https://" + window.location.host + "/admin/orders.json", true);
    xhr.withCredentials = true;
    xhr.onreadystatechange = function() { if (xhr.readyState == 4) {
        var tempOrders = JSON.parse(xhr.responseText, function(k, v) {
            if (!k)  // can't remember why? b/c of root?
                return v;
            if (typeof v === "string" && ['placed', 'paid', 'ordered', 'received', 'shipped', 'arrived', 'delivered'].indexOf(k) != -1)
                v = new Date(v);
            return v;
        } );
        var withCommas = function(n) { return String(n).replace(/\B(?=(\d{3})+(?!\d))/g, ','); };
        tempOrders.forEach(function(order) {
            if (order.currency == 'KES') {
                order.total = Math.round(order.total);
                order.totalStr = String(order.total).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            } else {
                order.totalStr = String(order.total).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
            order.phone = String(order.phone)
            while (order.phone.length < 10) order.phone = "0" + order.phone;
            order.phone = order.phone.substr(0,4) + "-" + order.phone.substr(4);
            order.bundles.forEach(function(bundle) {
                bundle.order = order;
                bundle.itemCount = bundle.items.reduce(function(total, item) { return total + item.quantity }, 0);
                bundle.total = bundle.items.reduce(function(total, item) { return total + (item.quantity * item.price) }, 0);
                bundle.totalStr = bundle.total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                bundle.items.forEach(function(item) {
                    item.priceStr = item.price.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    item.priceStrKES = withCommas(Math.round(item.price * order.exchange_rate));
                });
            });
            order.subtotalStr = withCommas(Math.round(order.subtotal_usd * order.exchange_rate));
            order.customsStr = withCommas(Math.round(order.customs_usd * order.exchange_rate));
            order.shippingStr = withCommas(Math.round(order.shipping_usd * order.exchange_rate));
            order.vatStr = withCommas(Math.round(order.vat_usd * order.exchange_rate));
        });
        tempOrders.forEach(function(o) { orders[o.id] = o });
        callback();
    } };
    xhr.send();
}

loadOrders(function() { window.addEventListener('popstate', route, false); route(); });