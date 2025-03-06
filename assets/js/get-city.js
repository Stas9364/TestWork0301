const form = document.getElementById("search-city-form");

const tHeaders = document.querySelector(".weather-table--headers");
const tBody = document.getElementById("weather-table-body");
const loader = document.querySelector(".loader");

const submitBtn = document.getElementById("submit");
const allCitiesBtn = document.getElementById("all-cities");

if (form) {
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(form);

    dataRequest(formData, 'submit');
  });

  allCitiesBtn.addEventListener("click", function (event) {
    event.preventDefault();

    const formData = new FormData(form);

    dataRequest(formData, 'click');
  });
}

function dataRequest(formData, btnType) {
  loader.classList.add("loading");
  tHeaders.classList.add("loading");

  submitBtn.setAttribute("disabled", "disabled");
  allCitiesBtn.setAttribute("disabled", "disabled");

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

      form.reset();
    })
    .catch((error) => {
      console.log(error);
    })
    .finally(() => {
      loader.classList.remove("loading");
      tHeaders.classList.remove("loading");

      submitBtn.removeAttribute("disabled");
console.log(btnType);

      if (btnType === "submit") {
        allCitiesBtn.removeAttribute("disabled");
      }
    });
}

function resultContent(data) {
  let result = "";

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
