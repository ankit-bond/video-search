import json , re
from py2neo import Graph, Node, Relationship
import os
from pprint import pprint
from bson import json_util
import sys


graph = Graph(password="ankit")
# print("Connected to neo4j server")

to_search = sys.argv[1]
query = """
match (n)-[r:SCORE]->(p) where n.id={name} return p order by r.val Desc,p.viewCount Desc limit 10
"""

data = graph.run(query, name = to_search)
docs = []
# print(type(data))
for d in data:
	t = json_util.dumps(d)
	docs.append(t)
	# print(t)
    # print(type(d))
    # print(d)

print('#####'.join(docs))