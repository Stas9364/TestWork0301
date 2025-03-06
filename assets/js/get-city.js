const form = document.getElementById("search-city-form");

const tHeaders = document.querySelector(".weather-table--headers");
const tBody = document.getElementById("weather-table-body");
const loader = document.querySelector(".loader");

const submitBtn = document.getElementById("submit");

if (form) {
  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(form);

    loader.classList.add("loading");
    tHeaders.classList.add("loading");

    submitBtn.setAttribute("disabled", "disabled");

    fetch(ajaxurl, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((res) => {
        const { success, data } = res.data;

        if (success) {
          resultContent(data);
        }
      })
      .catch((error) => {
        console.log(error);
      })
      .finally(() => {
        loader.classList.remove("loading");
        tHeaders.classList.remove("loading");

        submitBtn.removeAttribute("disabled");
      });
  });
}

function resultContent(data) {
  let result = "";

  console.log(data);
  if (data.length) {
    data.forEach((item) => {
      result += `<tr>
      <td>${item.country_name}</td>
      <td>${item.city_name}</td>
      <td>${item.temperature}</td>
    </tr>`;
    });
  } else {
    result = `<tr><td colspan="3" style="text-align: center;">Cities not found</td></tr>`;
  }

  tBody.innerHTML = result;
}
