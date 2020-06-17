<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Users</title>
    <style></style>
  </head>
  <body>
    <h1> Users </h1>

    <h2> Add a new user </h2>
    <form name="addUser">
      <input name="first_name" placeholder="First Name">
      <input name="last_name" placeholder="Last Name">
      <input name="email" placeholder="Email Address">
      <input type="submit" value="save">
    </form>

    <h2> User list </h2>
    <table style="width:100%" id="user-table">
      <tr class="header">
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
        <th>&nbsp;</th>
      </tr>
    </table>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>

      $(document).ready(function() {
        // Populate the table of users
        getUsers();

        // bind form submit
        $("form").submit(function(e) {
          e.preventDefault();

          var data = {}
          var $inputs = $(this).find("input");

          $inputs.each(function() {
            data[this.name] = $(this).val();
          });

          addUser(data);
        });
      });

      function getUsers() {
        $.get("/user").done(function(response) {
          refreshUserTable(response.data);
        });
      }

      function deleteUser(id) {
        $.ajax({"url": "/user/" + id, "type": "DELETE"})
          .done(function(response) {
            getUsers();
          });
      }

      function addUser(user) {
        $.post("/user", user).done(function(response) {
          getUsers();
        });
      }

      function refreshUserTable(data) {
        var $userTable = $("#user-table");
        var $rows = $userTable.find("tr").not(".header").remove();

        for (var i = 0; i < data.length; i++) {
          $userTable.append(factoryUserTableRow(data[i]));
        }

        // bind delete buttons
        $(".delete-user").click(function() {
          deleteUser($(this).data("id"));
        });
      }

      function factoryUserTableRow(user) {
        return  "<tr><td>" + user.first_name + 
                "</td><td>" + user.last_name + 
                "</td><td>" + user.email + 
                "</td><td><button data-id='" + user.id + 
                "' class='delete-user'>Delete</button></td></tr>";
      }
    </script>
  </body>
</html>