function Zeam(authorizations) {
    this.authorizations = authorizations;
    this.url = "https://api.sandbox.zeamster.com/v1/cardTickets";

    this.requestTicket = function (options) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", this.url, true);

        xmlhttp.setRequestHeader("Content-type", "application/json");
        xmlhttp.setRequestHeader("Location-Api-Key", this.authorizations.location_api_key);
        xmlhttp.setRequestHeader("Authorization", "ZEAM " + this.authorizations.signature);
        xmlhttp.setRequestHeader("Timestamp", this.authorizations.timestamp);
        xmlhttp.setRequestHeader("Order-Id", this.authorizations.order_id);

        xmlhttp.send(JSON.stringify(options.data));
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4) {
                options.responseHanlder(xmlhttp.status, JSON.parse(xmlhttp.responseText));
            }
        }
    }
}