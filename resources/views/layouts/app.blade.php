<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>
    @yield('title', 'SIAKAD')
</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
      href="{{ asset('css/page.css') }}">

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="stylesheet"
      href="{{ asset('css/style.css') }}">

</head>

<body>

@include('layouts.header')

@include('layouts.navbar')

<div class="main-content">

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

function universalSearch() {

    let input =
        document.getElementById("globalSearch");

    if (!input) return;

    let filter =
        input.value.toLowerCase();

    let tables =
        document.querySelectorAll("table");

    tables.forEach(function(table) {

        let tbody =
            table.querySelector("tbody");

        let rows =
            tbody.querySelectorAll("tr");

        let found = false;

        rows.forEach(function(row) {

            if (row.classList.contains("not-found-row"))
                return;

            let text =
                row.innerText.toLowerCase();

            if (text.includes(filter)) {

                row.style.display = "";
                found = true;

            } else {

                row.style.display = "none";

            }

        });

        let notFoundRow =
            table.querySelector(".not-found-row");

        if (!found) {

            if (!notFoundRow) {

                let tr =
                    document.createElement("tr");

                tr.classList.add("not-found-row");

                let td =
                    document.createElement("td");

                td.colSpan =
                    table.querySelectorAll("thead th").length;

                td.style.textAlign = "center";

                td.style.fontWeight = "600";

                td.style.color = "#dc3545";

                td.innerHTML =
                    "Data tidak ditemukan";

                tr.appendChild(td);

                tbody.appendChild(tr);

            }

        } else {

            if (notFoundRow) {

                notFoundRow.remove();

            }

        }

    });

}

</script>

@yield('scripts')

</body>

</html>