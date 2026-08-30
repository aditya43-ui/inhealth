<style>
    .table-container {
      width: 400px;
      height: 300px;
      overflow: auto;
      position: relative;
    }

    .freeze-column {
      position: absolute;
      top: 0;
      width: 100px; /* Width of the frozen column */
      left: 0;
      background-color: #f2f2f2;
      z-index: 2;
    }

    .freeze-row {
      position: absolute;
      left: 0;
      height: 30px; /* Height of the frozen row */
      top: 0;
      background-color: #f2f2f2;
      z-index: 1;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .freeze-column th:nth-child(1),
    .freeze-column td:nth-child(1) {
      position: sticky;
      left: 0;
    }
    .freeze-column th:nth-child(2),
    .freeze-column td:nth-child(2) {
      position: sticky;
      left: 50px;
    }

    .freeze-column td:nth-child(1),
    .freeze-column td:nth-child(2) {
      background-color: green;
    }
  </style>

<div class="table-container">
  <div class="freeze-column">
    <table>
      <thead>
        <tr>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
          <th>Frozen Column</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
        </tr>
        <tr>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
          <td>Data 1</td>
        </tr>
       
      </tbody>
    </table>
  </div>
</div>