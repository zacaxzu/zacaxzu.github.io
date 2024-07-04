<template>
  <div>
    <h1>Raspored za aktuarski studij</h1>
    <div id="liveTable">
      <table>
        <thead>
          <tr>
            <th>Vrijeme</th>
            <th>Ponedjeljak</th>
            <th>Utorak</th>
            <th>Srijeda</th>
            <th>Četvrtak</th>
            <th>Petak</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in tableData" :key="index">
            <td>{{ row[0] }}</td>
            <td v-for="(cell, dayIndex) in row.slice(1)" :key="dayIndex" contenteditable @input="updateTableCell(index, dayIndex, $event)">{{ cell }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tableData: []
    };
  },
  created() {
    this.loadTable();
  },
  methods: {
    loadTable() {
      // Replace with your API URL or PHP endpoint
      const baseUrl = 'http://localhost:3000/library/index.php?rt=rezervacije/aktuarski';
      fetch(`${baseUrl}/view/rezervacije/get_table.php`)
        .then(response => response.json())
        .then(data => {
          this.tableData = data;
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },
    updateTableCell(row, day, event) {
      const value = event.target.textContent.trim();
      // Replace with your API URL or PHP endpoint
      const baseUrl = 'http://localhost:3000/library/index.php?rt=rezervacije/aktuarski';
      fetch(`${baseUrl}/view/rezervacije/save_table.php`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          row: row,
          day: day,
          value: value
        })
      })
      .then(response => response.text())
      .then(data => {
        console.log('Save response:', data);
      })
      .catch(error => {
        console.error('Error saving data:', error);
      });
    }
  }
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  border: 1px solid black;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #04AA6D;
}
</style>
