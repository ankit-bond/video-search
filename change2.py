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
match (n) where n.id={name} set n.viewCount = n.viewCount+1 return n
"""

data = graph.run(query, name = to_search)