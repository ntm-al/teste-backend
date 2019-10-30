<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Document!</title>

    <style type="text/css">table.table{width: 95%;margin: auto;}
      .spinner-border{position: absolute!important;z-index:1!important;top:10vw!important;left:26vw!important;width:13vw!important;height:13vw!important;}
      .regional-text{border: 1px solid black; background-color: gray}
      .container-table{overflow: auto;height: 600px;}
    </style>
</head>

    <!-- Spinner loading -->
    <div class="spinner-border" role="status" style="display: none ">
      <span class="sr-only">Loading...</span>
    </div>
    <div class="main" >
      <div class="row">
        <div class="col-md-8 container-table">
          <div class="row">
            <table class="table">
              <thead class="thead-dark"  style="text-align: center">
                <tr>
                  <th scope="col">Regional</th>
                  <th scope="col">Média</th>
                </tr>
              </thead>
              <tbody class="dataList" style="text-align: center">
              </tbody>
            </table>
          </div> 
        </div>
        <div class="col-md-3">
          <div class="nacional">
            <h1>TOTAL REGIONAL:</h1>
            <div class="regional-text">
            </div>
          </div>
          <br>
          <div class="col-md-12 ">
              <div  class="row">
                <div class="nav-item col-md-6">
                  <button type="button" class="btn btn-outline-success" onclick="loadData()" style="width: 100%">Listar</button>
                </div>
                <div class="nav-item col-md-6">
                 <button  class="btn btn-dark" onclick="hiddenData()" style="width: 100%">Esconder</button>  
                </div>
              </div>
            </div>
        </div>  
      </div>
      
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script> 
      function loadData() { 

        document.querySelector('.spinner-border').style.display = 'flex';
        
        var xhttp = new XMLHttpRequest();       
        xhttp.onreadystatechange = function() {                                              
          if (this.readyState == 4 && this.status == 200) {

            let data         = JSON.parse(this.responseText);
            let students     = data['regionals'];
            let national     = data['national'];
            var tag_h1       = document.createElement('h1');

            tag_h1.innerText = national;

            document.querySelector('.regional-text').appendChild(tag_h1);

            students.forEach( (student) => {

              var tr   = document.createElement('tr');
              var sub1 = document.createElement('td');
              var sub2 = document.createElement('td');

              sub1.innerText = student.description;
              sub2.innerText = student.average;
              sub1.setAttribute('class', 'student-data');
              sub2.setAttribute('class', 'student-data');

              tr.appendChild(sub1);
              tr.appendChild(sub2);

              document.querySelector('.dataList').appendChild(tr);

              document.querySelector('.spinner-border').style.display = 'none';
            });
          }
        };
        xhttp.open("GET", "http://localhost:8000/api/getStudents", true);
        xhttp.send();
      }    
      function hiddenData() {
        document.querySelectorAll('.student-data').forEach(item => item.style.display = 'none');
        document.querySelectorAll('.regional-text').forEach(item => item.style.display = 'none');
      }  
    </script>
</html>
