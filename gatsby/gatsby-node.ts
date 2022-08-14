import type { GatsbyNode } from "gatsby"
import path from "path"

export const createPages: GatsbyNode["createPages"] = ({ actions, graphql }) => {

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
