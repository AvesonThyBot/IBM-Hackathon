// Variables
const type = new URL(location.href).searchParams.get("type");
const apiDiv = document.querySelectorAll(".api-data");
const options = {
  method: "GET",
  headers: {
    "X-Api-Key": "9SDLTme6r5WJl9/BAYoPGw==Hwh4scgedo7IXe5h", // Api key should be placed in env variables in actual projects
    "Content-Type": "application/json",
  },
};

// Function to Capitalize first letter
function capitalize(string) {
  return string[0].toUpperCase() + string.slice(1);
}

// Function to assign value to each section of the page
function assignValue(data) {
  // Variables
  const name = apiDiv[0];
  const location = apiDiv[1];
  const kingdom = apiDiv[2];
  const animalClass = apiDiv[3];
  const family = apiDiv[4];
  const order = apiDiv[5];
  const prey = apiDiv[6];
  const nameOfYoung = apiDiv[7];
  const groupBehaviour = apiDiv[8];
  const threat = apiDiv[9];
  const lifeSpan = apiDiv[10];
  const height = apiDiv[11];
  const weight = apiDiv[12];
  const population = apiDiv[13];
  const features = apiDiv[14];
  const habitat = apiDiv[15];
  const diet = apiDiv[16];
  const skinType = apiDiv[17];
  const slogan = apiDiv[18];

  //   Assign Value
  console.log(data);
  name.innerHTML += data.name || "unknown";

  //   Assign Value
  location.innerHTML += data.locations[0] || "unknown";

  //   Assign Value
  kingdom.innerHTML += data.taxonomy.kingdom || "unknown";

  //   Assign Value
  animalClass.innerHTML += data.taxonomy.class || "unknown";

  //   Assign Value
  family.innerHTML += data.taxonomy.family || "unknown";

  //   Assign Value
  order.innerHTML += data.taxonomy.order || "unknown";

  //   Assign Value
  prey.innerHTML += data.characteristics.prey || "unknown";

  //   Assign Value
  nameOfYoung.innerHTML += data.characteristics.name_of_young || "unknown";

  //   Assign Value
  groupBehaviour.innerHTML += data.characteristics.group_behavior || "unknown";

  //   Assign Value
  threat.innerHTML += data.characteristics.biggest_threat || "unknown";

  //   Assign Value
  lifeSpan.innerHTML += data.characteristics.lifespan || "unknown";

  //   Assign Value
  height.innerHTML += data.characteristics.height || "unknown";

  //   Assign Value
  weight.innerHTML += data.characteristics.weight || "unknown";

  //   Assign Value
  population.innerHTML += data.characteristics.estimated_population_size || "unknown";

  //   Assign Value
  features.innerHTML += data.characteristics.most_distinctive_feature || "unknown";

  //   Assign Value
  habitat.innerHTML += data.characteristics.habitat || "unknown";

  //   Assign Value
  diet.innerHTML += data.characteristics.diet || "unknown";

  //   Assign Value
  skinType.innerHTML += data.characteristics.skin_type || "unknown";

  //   Assign Value
  slogan.innerHTML += data.characteristics.slogan || "unknown";

  //   Assign
}

// ASYNC function to fetch API data
async function fetchAnimalData(name) {
  try {
    const response = await fetch(
      `https://api.api-ninjas.com/v1/animals?name=${name}`,
      options
    );

    // Assign result
    let data = await response.json();

    // Remove all spinners
    apiDiv.forEach((element) => {
      element.querySelector(".spinner-border").remove();
    });

    //   Filter to correct data
    for (let index = 0; index < data.length; index++) {
      if (data[index].name == capitalize(type)) {
        data = data[index]; //assign correct data
        break;
      } else if (index == data.length - 1) {
        data = data[index]; //assign final data
        break;
      }
    }

    // Function to assign value
    assignValue(data);
  } catch (error) {
    // Handle errors
    console.error("Error fetching data:", error);
  }
}

// Only run if type is valid
if (type !== null) {
  fetchAnimalData(type);
}
