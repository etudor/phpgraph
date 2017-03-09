Generate a graph from your php project

Example of a graph generated from this project:
![phpgraph](https://raw.githubusercontent.com/etudor/phpgraph/master/web/graph.png)

Todo:
- add more dependency extractors
- group classes external to project by external component. For current example 
all classes under symfony/component will appear as a single block. 
We don't care about what class our module depends on, 
but from where our dependencies on external modules comes from 
so that we can gather them and abstract them.
- read phpDoc blocks.
- and much more
- find the common namespace inside the scanned module and remove the name from class boxes. (shorter to read)
- make the graph readonly

