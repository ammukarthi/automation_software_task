<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Products List!</title>
  </head>
  <body>

    <div class="container">

            <?php $session = \Config\Services::session(); if($session->getFlashdata('success')){?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success !</strong> <?php  echo $session->getFlashdata('success');?>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php } ?> 

        <h3 class="pt-3">Product Lists</h3>

        <div class="text-right"> 
        <button type="button" class="btn btn-info"><a style="color:#fff;" href="<?php echo site_url('logout'); ?>">Logout</a></button>
        </div>

        <div class="row">
            
            <div class="col-md-6 pt-5">
                <label>Sort By</label>
                <select class="form-select" id="sorting" aria-label="Default select example">
                    <option selected value="recent_projects">Recent Projects</option>
                    <option value="category_name">Order by category name asc</option>
                    <option value="user_name">Order by username asc</option>
                    <option value="project_title">Order by Project Title asc</option>
                </select>
            </div>

        </div>
        <div class="row">

            <div class="col-md-12 pt-5">

            <table id='projectList' class="table table-bordered">
                <thead>
                <tr>
                    <th>Project Title</th>
                    <th>User Name</th>
                    <th>Category Name</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

            <div id='pagination'></div>	

            </div>
            
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type='text/javascript'>
        $(document).ready(function() {

            createPagination(0);

            $('#pagination').on('click','a',function(e){
                e.preventDefault(); 
                var pageNum = $(this).attr('href');
                var check = pageNum.split('=').pop();
                console.log(check);
                createPagination(check);
            });

            $('#sorting').on('change',function(e){
               
                createPagination(0);

            });

            function createPagination(pageNum){

                var sort = $('#sorting').val();
                console.log(sort);

                $.ajax({
                    url: '<?=base_url()?>index.php/products/list/'+pageNum+'/'+sort,
                    type: 'get',
                    dataType: 'json',
                    success: function(responseData){
                        console.log(responseData);
                        $('#pagination').html(responseData.pagination);
                        paginationData(responseData.projectRecord);
                    }
                });
            }

            function paginationData(data) {
                $('#projectList tbody').empty();
                console.log(data);
                for(project in data){
                    var projectRow = "<tr>";
                    projectRow += "<td>"+ data[project].project_title +"</td>";
                    projectRow += "<td>"+ data[project].username +"</td>";
                    projectRow += "<td>"+ data[project].category_name +"</td>"
                    projectRow += "</tr>";
                    $('#projectList tbody').append(projectRow);					
                }
            }
        });
        </script>

</body>
</html>