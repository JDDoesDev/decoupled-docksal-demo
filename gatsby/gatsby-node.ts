import type { GatsbyNode } from "gatsby"
import path from "path"

export const createPages: GatsbyNode["createPages"] = async ({ actions, graphql }) => {
  const { createPage, createRedirect } = actions

  const Recipes = await graphql(
    `query {
      allNodeRecipe {
        nodes {
          id
          drupal_internal__nid
          path {
            alias
          }
        }
      }
    }
    `
  )

  const recipeTemplate = path.resolve(`./src/templates/Recipe/Recipe.tsx`)

  // Create recipe pages.
  Recipes.data.allNodeRecipe.nodes.map((node) => {
    createPage({
      path: node.path.alias,
      component: recipeTemplate,
      context: {
        id: node.id,
      }
    })
  })
}

export const onCreateWebpackConfig: GatsbyNode["onCreateWebpackConfig"] = ({ actions }) => {
  actions.setWebpackConfig({
    watchOptions: {
      aggregateTimeout: 200,
      poll: 1000,
      ignored: ["**/graphql-*.ts"]
    },
    resolve: {
      modules: [path.resolve(__dirname, "src"), "node_modules"],
    },
  })
}
